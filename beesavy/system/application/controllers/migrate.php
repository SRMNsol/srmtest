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

        $query = $this->db
            ->from('user')
            ->select('id, email')
            ->order_by('id', 'asc')
            ->limit($limit);

        if (null === $gtid) {
            $query->where('last_sync is null');
        } else {
            $query->where('id > ', $gtid);
        }

        $users = $query->get()->result_array();

        foreach ($users as $user) {
            echo sprintf('Id: %s Email: %s', $user['id'], $user['email']), PHP_EOL;
            $summary = $this->cache->library('beesavy', 'getUserStats', [$user['id']], 3600);
            $referrals = $this->cache->library('extrabux', 'getUserReferrals', [$user['id']], 3600);
            $report = $this->cache->library('extrabux', 'getUserReport', [$user['id']], 3600);
            $stats = $this->cache->library('extrabux', 'getUserStats', [$user['id']], 3600);

            $data = [
                'raw_data' => json_encode([
                    'user' => $user,
                    'summary' => $summary,
                    'referrals' => $referrals,
                    'report' => $report,
                    'stats' => $stats,
                ]),
                'last_sync' => date('Y-m-d H:i:s'),
            ];

            $this->db->update('user', $data, ['id' => $user['id']]);
        }
    }
}
