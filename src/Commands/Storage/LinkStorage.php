<?php

    namespace Eskirex\Component\Framework\Commands\Storage;

    use Eskirex\Component\Console\Command;
    use Eskirex\Component\Console\Output;
    use Eskirex\Component\Console\Input;

    class LinkStorage extends Command
    {
        public function configure()
        {
            $this->setName('storage:link')
                ->setDescription('Storage link description')
                ->setHelp('Storage link help');
        }


        public function execute(Input $input, Output $output)
        {
            echo 'storage link';
        }
    }