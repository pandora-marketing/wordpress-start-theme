<?php


namespace PandoraMarketing\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputArgument, InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;

class GeneratorFileFuntion extends Command
{
    protected $commandName = 'make:function';
    protected $commandDescription = 'Create custom post type files or custom taxonomy files';

    protected $commanArgumentName = 'filename';
    protected $commanArgumentDescription = 'File Name';

    protected $commanOptionName = 'type';
    protected $commanOptionDescription = 'Custom post type file or Custom taxonomy file';

    protected $filename;
    protected $type;
    protected $dir;

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commanArgumentName,
                InputArgument::REQUIRED,
                $this->commanArgumentDescription
            )
            ->addOption(
                $this->commanOptionName,
                null,
                InputOption::VALUE_REQUIRED,
                $this->commanOptionDescription
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->filename = $input->getArgument('filename');
        $this->type = $input->getOption('type');

        if ( $this->type == 'post-type' ) {
            $this->dir = 'post-types';
            $res = $this->functionFileExist();
        } elseif ( $this->type == 'taxonomy' ) {
            $this->dir = 'taxonomies';
            $res = $this->functionFileExist();
        } else {
            $res = 'Error';
        }
        $output->writeln($res);
    }

    protected function createFile()
    {
        file_put_contents(
            "app/registers/{$this->dir}/{$this->filename}.php",
            $this->compileFileStub()
        );
    }

    protected function compileFileStub()
    {
        return str_replace(
            '{{name_function}}',
            $this->filename,
            file_get_contents("commands/stubs/functions/{$this->type}.stub")
        );
    }

    protected function functionFileExist()
    {
        if ( ! file_exists("app/registers/{$this->dir}/{$this->filename}.php") ) {
            $this->createFile();
            return 'Created file.';
        } else {
            return 'El Archivo existe';
        }
    }
}
