<?php
/**
 */
class Cashback extends Controller
{
    protected $container;

    public function Cashback()
    {
        parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('user');
        $this->user_id = $this->user->get_field('id');

        $this->load->helper('bridge');
        $this->load->helper('escape');
        $this->container = silex();
    }

    public function __get_header(&$data)
    {
        if (!$this->user->login_status()) {
            redirect('main/signin?user=&code=20');
        }
        $blocks = $this->blocks->getBlocks();
        $data2 = $this->beesavy->getUser($this->user_id, '', TRUE);
        $data = array_merge($data, $data2);
        $data = array_merge($data, $blocks);
        $data =array_merge($data, $this->user->info());
    }

    public function index()
    {
        $data = $this->cache->library('beesavy', 'getUserStats', array($this->user_id), 3600);
        $this->__get_header($data);
        #Have columns: Month, Type, Status, Cash Back, Payment date

        $em = $this->container['orm.em'];

        $result = $em->getRepository('App\Entity\Cashback')->getMostRecentUserCashback(
            $em->getReference('App\Entity\User', $this->user_id)
        );

        $data['transactions'] = array_map(function (App\Entity\Cashback $cashback) {
            $data['month'] = $cashback->getTransactions()->current()->getRegisteredAt()->format('m/d/Y');
            $data['transtype'] = 'Personal';
            $data['status'] = ucfirst($cashback->getStatus());
            $data['cashback'] = sprintf('%.2f', $cashback->getAmount());
            $data['date'] = $cashback->getStatus() === App\Entity\Cashback::STATUS_PAID
                ? $cashback->getTransactions()->current()->getRegisteredAt()->format('m/Y')
                : 'N/A';

            return $data;
        }, $result);

        $result = $em->getRepository('App\Entity\Referral')->getMostRecentUserReferral(
            $em->getReference('App\Entity\User', $this->user_id)
        );

        $referrals = [];
        array_walk($result, function (App\Entity\Referral $referral) use (&$referrals) {
            foreach (['pending', 'paid', 'available'] as $status) {
                $method = 'get' . ucfirst($status);
                $value = $referral->$method();
                if ($value > 0) {
                    $referrals[] = [
                        'month' => $referral->getAvailableAt()->format('m/Y'),
                        'transtype' => $referral->getConcept(),
                        'status' => ucfirst($status),
                        'cashback' => sprintf('%.2f', $value),
                        'date' => 'N/A'
                    ];
                }
            }
        });

        $data['reftransactions'] = $referrals;
        $this->parser->parse('cashback/base', $data);
    }

    public function personal()
    {
        $data = $this->beesavy->getUserStats($this->user_id);
        $this->__get_header($data);
        $data['type'] = "personal";

        $em = $this->container['orm.em'];

        $result = $em->getRepository('App\Entity\Cashback')->getMostRecentUserCashback(
            $em->getReference('App\Entity\User', $this->user_id)
        );

        $data['transactions'] = array_map(function (App\Entity\Cashback $cashback) {
            $transaction = $cashback->getTransactions()->current();

            $data['report_date'] = $transaction->getRegisteredAt()->format('m/d/Y');
            $data['merchant'] = $cashback->getConcept();
            $data['order_id'] = $transaction->getOrderNumber();
            $data['status'] = ucfirst($cashback->getStatus());
            $data['amount'] = sprintf('%.2f', $transaction->getTotal());
            $data['cashback'] = sprintf('%.2f', $cashback->getAmount());

            return $data;
        }, $result);

        $this->parser->parse('cashback/base', $data);
    }

    public function referral()
    {
        $data = $this->beesavy->getUserStats($this->user_id);
        $this->__get_header($data);
        $data['type'] = "referral";

        $reftransactions = $data['reftransactions'];
        $newref = array();
        foreach ($reftransactions as &$trans) {
            $date = $trans['date'];
            $level = "Referral Total";
            $status = "";
            $cashback = 0;
            $stati = array("Paid"=>"referralpaid",
                "Pending"=>"referralpending",
                "Processing"=>"referralprocessing",
                "Available"=>"referralavailable");
            foreach ($stati as $k=>$v) {
                $cashback += (float) $trans[$v];
                if ($trans[$v] != "0.00" && !$status) {
                    $status = $k;
                } elseif ($trans[$v] != "0.00" && $status) {
                    $status = "Mixed";
                }
            }
            if ($cashback!=0) {
                $newref[] = array(
                    'date'=>$date,
                    'level'=>$level,
                    'status'=>$status,
                    'cashback'=>number_format($cashback, 2)
                );
            }
            if ($cashback!=0) {
                $levi = array('Level 1'=>'referralcommissiondirect',
                    'Level 2-7'=>'referralcommissionindirect');
                foreach ($levi as $lev=>$lev_index) {
                    $newref[] = array(
                        'date'=>$date,
                        'level'=>$lev,
                        'status'=>$status,
                        'cashback'=>$trans[$lev_index]
                    );
                }
            }
        }
        $data['reftransactions'] = $newref;
        $this->parser->parse('cashback/base', $data);
    }
}
