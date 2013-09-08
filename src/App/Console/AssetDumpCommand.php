<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use App\TemplatingProvider;

class AssetDumpCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('asset:dump')
            ->setDescription('Compile and dump all assets to public directory');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getHelperSet()->get('container')->getContainer();
        $app->register(new TemplatingProvider());

        $dumper = $app['assetic.dumper'];
        $dumper->setTwig($app['twig'], $app['twig.loader.filesystem']);

        $output->write('Building assets ... ');
        $dumper->dumpAssets();
        $output->writeln('Done');

        $output->write('Copying fonts ... ');
        $dest = $app['assetic.path_to_web'] . '/fonts';
        if (!file_exists($dest) || !is_dir($dest)) {
            mkdir($dest);
        }
        foreach (glob($app['twbs.resources_dir'] . '/fonts/glyphicons-halflings-regular.*') as $font) {
            copy($font, $dest . '/' . basename($font));
        }
        $output->writeln('Done');
    }
}
