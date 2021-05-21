<?php

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class FirstSetupCommand extends Command
{
    private $simulation = false;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'byscripts:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial setup for new projects.';
    private $projectName;
    private $sProjectName;
    private $uProjectName;
    private $prodDomainName;
    private $devDomainName;
    private $env;
    private $regex = '`/\* BYSCRIPTS_SETUP\:([^\:]+):([^\*]+)\*/`';

    public function ask($question, $default = null)
    {
        if (null === $default) {
            return parent::ask($question . ' ', $default);
        }

        $displayDefault = trim(var_export($default, true), '\'');

        return parent::ask($question . ' [' . $displayDefault . '] ', $default);
    }

    private function storeMeta()
    {
        $path = __DIR__ . '/../storage/bss.meta';

        $meta = [
            'projectName'  => $this->projectName,
            'sProjectName' => $this->sProjectName,
            'uProjectName' => $this->uProjectName,
            'devDomainName' => $this->devDomainName
        ];

        file_put_contents($path, "<?php\nreturn " . var_export($meta, true) . ';');
    }


    private function loadMeta()
    {
        $path = __DIR__ . '/../storage/bss.meta';
        if (file_exists($path)) {
            $meta = require($path);
            $this->projectName = $meta['projectName'];
            $this->sProjectName = $meta['sProjectName'];
            $this->uProjectName = $meta['uProjectName'];
            $this->devDomainName = $meta['devDomainName'];

            return true;
        }

        return false;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if ($this->simulation) {
            $this->info('=================');
            $this->info(' SIMULATION MODE ');
            $this->info('=================');
        }
        $this->env = $this->ask('Which env to configure (dev, prod)?', 'dev');

        if ('prod' === $this->env) {
            $this->regex = str_replace('BYSCRIPTS_SETUP', 'BYSCRIPTS_SETUP_PROD', $this->regex);
        }

        if (!$this->loadMeta()) {
            $this->projectName  = $this->ask('Project name:');
            $this->sProjectName = Str::slug($this->projectName);
            $this->uProjectName = Str::slug($this->projectName, '_');
            if ('dev' === $this->env) {
                $this->devDomainName = $this->ask('Dev domain name:', $this->getDefaultDevDomainName());
            }
            $this->storeMeta();
        }


        if ('prod' === $this->env) {
            $this->prodDomainName = $this->ask('Prod domain name:', $this->getDefaultProdDomainName());
        } else {

        }

        $this->line('');
        $this->info('If you want to skip a configuration for the moment, enter ~ as a value.');
        $this->line('');

        $this->startParsing();
    }

    private function startParsing()
    {
        $finder = new Finder();

        /** @var Symfony\Component\Finder\SplFileInfo $file */
        foreach ($finder->files()->in(__DIR__ . '/../config') as $file) {

            $hasMatch = false;
            $content  = $file->getContents();
            preg_match_all($this->regex, $content, $matches, PREG_SET_ORDER);

            if (!empty($matches)) {

                $title = sprintf('Configuring %s...', $file->getRelativePathname());
                $this->line('');
                $this->info($sep = str_repeat('=', strlen($title)));
                $this->info($title);
                $this->info($sep);
                $this->line('');

                $hasMatch = true;

                foreach ($matches as $match) {
                    $source   = $match[0];
                    $question = trim($match[1]);
                    $default  = trim($match[2]);

                    if (0 === strpos($default, '@')) {
                        $method  = trim($default, '@');
                        $default = call_user_func([$this, $method]);
                    }

                    $value = $this->ask($question, $default);

                    if ('~' === $value) {
                        continue;
                    }

                    $content = str_replace($source, $value, $content);
                }
            }

            if ($hasMatch) {
                if (!$this->simulation) {
                    file_put_contents($file->getPathname(), $content);
                }
                $this->line('');
                $this->comment('>>> File updated...');
            }
        }
    }

    private function getDefaultProdDomainName()
    {
        return $this->sProjectName . '.com';
    }

    private function getDefaultDevDomainName()
    {
        return $this->sProjectName . '.local';
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function getDefaultProdUrl()
    {
        return 'http://' . $this->prodDomainName;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function getDefaultDevUrl()
    {
        return 'http://' . $this->devDomainName;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function getDefaultFromEmailAddress()
    {
        return 'contact@' . $this->prodDomainName;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function generateKey()
    {
        return Str::random(32);
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function getDefaultDbName()
    {
        return Str::limit($this->uProjectName, 64, '');
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function getProjectName()
    {
        return $this->projectName;
    }
}
