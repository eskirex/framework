<?php

    namespace Eskirex\Component\Framework\Commands\Asset;

    use Eskirex\Component\Config\Config;
    use Eskirex\Component\Console\Command;
    use Eskirex\Component\Console\Output;
    use Eskirex\Component\Console\Input;

    class MakeAsset extends Command
    {
        public function configure()
        {
            $this->setName('asset:build')
                ->setDescription('asset build description')
                ->setHelp('asset build help')
                ->setOption('compress', 'c', 'Compress');
        }


        public function execute(Input $input, Output $output)
        {
            $assetConfig = new Config('Asset');

            foreach ($assetConfig->all() as $type => $item) {
                $data = $this->getAllData($item['list'], $type);


                file_put_contents(PUBLIC_DIR . $item['public'], $data);

                
            }
        }


        public function getAllData(array $list, string $type)
        {
            $data = '';
            foreach ($list as $name) {
                $file = RESOURCE_DIR . $type . DS . $name;

                if (file_exists($file)) {
                    $get = file_get_contents($file);
                    $data .= $get;
                }
            }

            return $data;
        }
    }