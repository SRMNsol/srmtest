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

        $fixturesPath = isset($_SERVER['FIXTURES_PATH'])
            ? $_SERVER['FIXTURES_PATH']
            : null;

        if (!isset($fixturesPath) || !file_exists($fixturesPath) || !is_dir($fixturesPath) || !is_writable($fixturesPath)) {
            throw new RuntimeException('Need writable fixtures path');
        }

        foreach ($users as $user) {
            echo sprintf('Id: %s Email: %s', $user['id'], $user['email']), PHP_EOL;
            $summary = $this->cache->library('beesavy', 'getUserStats', [$user['id']], 3600);
            $referrals = $this->cache->library('extrabux', 'getUserReferrals', [$user['id']], 3600);
            $report = $this->cache->library('extrabux', 'getUserReport', [$user['id']], 3600);
            $stats = $this->cache->library('extrabux', 'getUserStats', [$user['id']], 3600);

            file_put_contents($fixturesPath . sprintf('/user-%d.dat', $user['id']), json_encode([
                'user' => $user,
                'summary' => $summary,
                'referrals' => $referrals,
                'report' => $report,
                'stats' => $stats,
            ], JSON_PRETTY_PRINT));
        }
    }
}
