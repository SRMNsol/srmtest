<?php

/**
 * Migration CLI
 */
class Migrate extends Controller
{
    public function __construct()
    {
        if (php_sapi_name() !== 'cli') {
            exit();
        }

        parent::Controller();
        $this->load->model('user');
        $this->load->model('admin');
    }

    public function user_download($limit = 1, $gtid = null)
    {
        echo 'Starting user download', PHP_EOL;

        $fixturesPath = isset($_SERVER['FIXTURES_PATH'])
            ? $_SERVER['FIXTURES_PATH']
            : null;

        if (!isset($fixturesPath) || !file_exists($fixturesPath) || !is_dir($fixturesPath) || !is_writable($fixturesPath)) {
            throw new RuntimeException('Need writable fixtures path');
        }

        $idFile = $fixturesPath . '/last-user-import.txt';
        touch($idFile);
        $useIdFile = false;

        if (null === $gtid) {
            $gtid = file_get_contents($idFile) ?: 0;
            $useIdFile = true;
        }

        $users = $this->db
            ->from('user')
            ->select('id, email')
            ->where('id > ', $gtid)
            ->order_by('id', 'asc')
            ->limit($limit)
            ->get()->result_array();

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

            if ($useIdFile) {
                file_put_contents($idFile, $user['id']);
            }
        }
    }
}
