<?php

/**
 * Migration CLI
 */
class Extrabux_Dl extends Controller
{
    public function __construct()
    {
        if (php_sapi_name() !== 'cli') {
            exit();
        }

        parent::Controller();
        $this->load->model('user');
        $this->load->model('admin');
        $this->load->library('old_extrabux');
        $this->load->library('old_beesavy');
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
            $account = $this->old_beesavy->getUser($user['id'], null, true);
            $summary = $this->old_beesavy->getUserStats($user['id']);
            $referrals = $this->old_extrabux->getUserReferrals($user['id']);
            $report = $this->old_extrabux->getUserReport($user['id']);
            $stats = $this->old_extrabux->getUserStats($user['id']);

            $data = [
                'raw_user_data' => json_encode($account),
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
