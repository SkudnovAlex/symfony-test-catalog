<?php
namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCommand extends Command
{
    protected static $defaultName = 'app:parse';
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Запустить парсер.')
            ->setHelp('Эта команда запускает парсер. Необходимо дополнительно указывать класс парсера через аргумент.')
            ->addArgument('class', InputArgument::REQUIRED, 'Класс парсера который находится в src/Parser');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $class = '\\App\\Parser\\' . $input->getArgument('class');
        if (!class_exists($class)) {
            $output->writeln("Класс $class не найден");
            return 1;
        }

        //TODO не получилось внедрить DI. возможно с динамическим классом нужно делать как то по иному.
        $parser = new $class($this->em);

        $output->writeln("Начинаем парсинг сайта $parser->baseUrl");
        $result = $parser->run();

        if ($result === null) {
            $output->writeln('Парсинг успешно завершен.');
            return 0;
        }

        $output->writeln("Произошла ошибка при парсенге: \n$result");
        return 1;
    }
}