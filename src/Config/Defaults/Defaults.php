<?php

namespace D3R\Proc\Config\Defaults;

/**
 * Defaults object containing default config values
 *
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Config\Defaults
 */
class Defaults implements DefaultsInterface
{
    /**
     * Array of default values
     *
     * @var array
     */
    protected $defaults = array();

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct()
    {
        $this->initDefaults();
    }

    /**
     * Initialise the defaults array
     *
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function initDefaults()
    {
        $this->defaults = array(
            // Base options
            'base.root'     => array(
                'value' => '/clients',
                'label' => 'The base directory for deployments'),
            'base.username' => array(
                'value' => 'none',
                'label' => 'The default username for authenticated actions'
            ),
            'base.password' => array(
                'value' => 'none',
                'label' => 'The default password for authenticated actions'
            ),

            // AWS settings
            'aws.key'        => array(
                'value'    => 'none',
                'label'    => 'AWS Access Key',
                'required' => true
            ),
            'aws.secret'     => array(
                'value'    => 'none',
                'label'    => 'AWS Secret Key',
                'required' => true
            ),
            'aws.region'     => array(
                'value'    => 'eu-west-1',
                'label'    => 'Default AWS region',
                'required' => true
            ),

            'mysql.username' => array(
                'value'    => 'root',
                'label'    => 'Default MySQL username',
                'required' => true
            ),
            'mysql.password' => array(
                'value'    => 'none',
                'label'    => 'Default MySQL password',
                'required' => true
            ),

            // Notification settings
            'notify.from'          => array(
                'value' => 'D3R Tools',
                'label' => 'Default source name for notifications'
            ),
            'notify.email'         => array(
                'value' => 'tools@d3r.com',
                'label' => 'Default source email for notifications'
            ),
            'notify.hipchat.token' => array(
                'value' => 'none',
                'label' => 'Default Hipchat API token'
            ),
            'notify.hipchat.room'  => array(
                'value' => 'none',
                'label' => 'Default Hipchat room id'
            ),

            // Utility paths
            'binary.mysqldump' => array(
                'value' => function () {
                    return passthru('/usr/bin/which mysqldump');
                },
                'label' => 'Path to the mysqldump binary'
            ),
            'binary.mysql'     => array(
                'value' => function () {
                    return passthru('/usr/bin/which mysql');
                },
                'label' => 'Path to the mysql client binary'
            ),
            'binary.gunzip'    => array(
                'value' => function () {
                    return passthru('/usr/bin/which gunzip');
                },
                'label' => 'Path to the gunzip binary'
            ),

            // Release options
            'release.bucket'   => array(
                'value' => 'd3r.assets.d3r.com',
                'label' => 'The bucket in which releases are stored'
            ),
            'release.path'     => array(
                'value' => '',
                'label' => 'The path (pseudo-directory) that releases are stored into'
            ),
        );
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function get($key)
    {
        if (isset($this->defaults[$key]['value'])) {
            if (is_callable($this->defaults[$key]['value'])) {
                return $this->defaults[$key]['value']();
            }
            return $this->defaults[$key]['value'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function label($key)
    {
        if (isset($this->defaults[$key]['label'])) {
            return $this->defaults[$key]['label'];
        }

        return $key;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getKeys()
    {
        return array_keys($this->defaults);
    }

    /**
     * Get a minimum set of required config keys
     *
     * @return array
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getRequiredKeys()
    {
        $keys   = array();
        foreach ($this->defaults as $key => $data) {
            if (isset($data['required']) && true === $data['required']) {
                $keys[] = $key;
            }
        }

        return $keys;
    }
}
