<?php

<<<<<<< HEAD
declare(strict_types=1);

=======
>>>>>>> 404660b (up)
namespace App\Listeners;

use Illuminate\Support\Str;
use samdark\sitemap\Sitemap;
use TightenCo\Jigsaw\Jigsaw;

class GenerateSitemap
{
    protected $exclude = [
        '/assets/*',
        '*/favicon.ico',
<<<<<<< HEAD
        '*/404',
=======
        '*/404'
>>>>>>> 404660b (up)
    ];

    public function handle(Jigsaw $jigsaw)
    {
        $baseUrl = $jigsaw->getConfig('baseUrl');

        if (! $baseUrl) {
<<<<<<< HEAD
            echo "\nTo generate a sitemap.xml file, please specify a 'baseUrl' in config.php.\n\n";
=======
            echo("\nTo generate a sitemap.xml file, please specify a 'baseUrl' in config.php.\n\n");
>>>>>>> 404660b (up)

            return;
        }

        $sitemap = new Sitemap($jigsaw->getDestinationPath() . '/sitemap.xml');

        collect($jigsaw->getOutputPaths())
            ->reject(function ($path) {
                return $this->isExcluded($path);
<<<<<<< HEAD
            })->each(
                function ($path) use ($baseUrl, $sitemap) {
                    $sitemap->addItem(rtrim($baseUrl, '/') . $path, time(), Sitemap::DAILY);
                }
            );
=======
            })->each(function ($path) use ($baseUrl, $sitemap) {
                $sitemap->addItem(rtrim($baseUrl, '/') . $path, time(), Sitemap::DAILY);
        });
>>>>>>> 404660b (up)

        $sitemap->write();
    }

    public function isExcluded($path)
    {
        return Str::is($this->exclude, $path);
    }
}
