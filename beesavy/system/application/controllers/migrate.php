<?php

/**
 * Migration CLI
 */
class Migrate extends Controller
{
    public function __construct()
    {
        parent::Controller();
        $this->load->model('user');
        $this->load->model('admin');
    }

    public function user_download()
    {
        echo 'Starting user download', PHP_EOL;

        $users = $this->db
            ->order_by('id', 'asc')
            ->get('user')
            ->result_array();

        foreach ($users as $user) {
            echo sprintf('Id: %s Email: %s', $user['id'], $user['email']), PHP_EOL;
            $summary = $this->cache->library('beesavy', 'getUserStats', [$user['id']], 3600);
            $referrals = $this->cache->library('extrabux', 'getUserReferrals', [$user['id']], 3600);
            $report = $this->cache->library('extrabux', 'getUserReport', [$user['id']], 3600);
            $stats = $this->cache->library('extrabux', 'getUserStats', [$user['id']], 3600);
        }
    }
}
