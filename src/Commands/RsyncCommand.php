<?php
/**
 * This command will manage secrets on a Pantheon site.
 *
 * See README.md for usage information.
 */

namespace Pantheon\TerminusRsync\Commands;

use Consolidation\OutputFormatters\StructuredData\PropertyList;
use Pantheon\Terminus\Commands\TerminusCommand;
use Pantheon\Terminus\Exceptions\TerminusException;
use Pantheon\Terminus\Site\SiteAwareInterface;
use Pantheon\Terminus\Site\SiteAwareTrait;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Manage secrets on a Pantheon instance
 */
class RsyncCommand extends TerminusCommand implements SiteAwareInterface
{
    use SiteAwareTrait;

    protected $info;
    protected $tmpDirs = [];

    /**
     * Object constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Call rsync on a Pantheon site
     *
     * @command remote:rsync
     * @aliases rsync
     *
     * @param string $src Source path
     * @param string $dest Destination path
     * @param array $rsyncOptions All of the options after -- (passed to rsync)
     */
    public function rsyncCommand($src, $dest, array $rsyncOptions)
    {
        if (strpos($src, ':') !== false) {
            $site_env_id = $this->getSiteEnvIdFromPath($src);
            $src = $this->removeSiteEnvIdFromPath($src);
        } else {
            $site_env_id = $this->getSiteEnvIdFromPath($dest);
            $dest = $this->removeSiteEnvIdFromPath($dest);
        }

        return $this->rsync($site_env_id, $src, $dest, $rsyncOptions);
    }

    /**
     * Call rsync to or from the specified site.
     *
     * @param string $site_env_id Remote site
     * @param string $src Source path to copy from. Start with ":" for remote.
     * @param string $dest Destination path to copy to. Start with ":" for remote.
     */
    protected function rsync($site_env_id, $src, $dest, array $rsyncOptions)
    {
        list($site, $env) = $this->getSiteEnv($site_env_id);
        $env_id = $env->getName();

        $siteInfo = $site->serialize();
        $site_id = $siteInfo['id'];

        // Stipulate the temporary directory to use iff the destination is remote.
        $tmpdir = '';
        if ($dest[0] == ':') {
            $tmpdir = '~/tmp';
        }

        $siteAddress = "$env_id.$site_id@appserver.$env_id.$site_id.drush.in:";

        $src = preg_replace('/^:/', $siteAddress, $src);
        $dest = preg_replace('/^:/', $siteAddress, $dest);

        // Get the rsync options string. If the user did not pass
        // in any mode options (e.g. '-r'), then add in the default.
        $rsyncOptionString = implode(' ', $rsyncOptions);
        if (!preg_match('/(^| )-[^-]/', $rsyncOptionString)) {
            $rsyncOptionString = "-rlIpz $rsyncOptionString";
        }
        // Add in a tmp-dir option if one was not already specified
        if (!empty($tmpdir) && !preg_match('/(^| )--temp-dir/', $rsyncOptionString)) {
            $rsyncOptionString = "$rsyncOptionString --temp-dir=$tmpdir --delay-updates";
        }

        $this->log()->notice('Running {cmd}', ['cmd' => "rsync $rsyncOptionString $src $dest"]);
        $this->passthru("rsync $rsyncOptionString --ipv4 --exclude=.git -e 'ssh -p 2222' '$src' '$dest' ");
    }

    protected function passthru($command)
    {
        $result = 0;
        passthru($command, $result);

        if ($result != 0) {
            throw new TerminusException('Command `{command}` failed with exit code {status}', ['command' => $command, 'status' => $result]);
        }
    }

    protected function getSiteEnvIdFromPath($path)
    {
        return preg_replace('/:.*/', '', $path);
    }

    protected function removeSiteEnvIdFromPath($path)
    {
        return preg_replace('/^[^:]*:/', ':', $path);
    }
}
