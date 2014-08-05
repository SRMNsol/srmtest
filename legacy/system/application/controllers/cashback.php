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
        $this->container = silex();
    }

    protected function __get_header(&$data)
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
        $data = $this->beesavy->getUserStats($this->user_id);
        $this->__get_header($data);
        #Have columns: Month, Type, Status, Cash Back, Payment date

        $em = $this->container['orm.em'];

        $result = $em->getRepository('App\Entity\Cashback')->getMostRecentUserCashback(
            $em->getReference('App\Entity\User', $this->user_id)
        );

        $data['transactions'] = array_map(function (App\Entity\Cashback $cashback) {
            $data['month'] = $cashback->getRegisteredAt() ? $cashback->getRegisteredAt()->format('m/d/Y') : null;
            $data['transtype'] = 'Personal';
            $data['status'] = ucfirst($cashback->getStatus());
            $data['cashback'] = sprintf('%.2f', $cashback->getAmount());
            $data['date'] = $cashback->getPaymentDate() ? $cashback->getPaymentDate()->format('m/d/Y') : 'N/A';

            return $data;
        }, $result);

        $result = $em->getRepository('App\Entity\Referral')->getMostRecentUserReferral(
            $em->getReference('App\Entity\User', $this->user_id)
        );

        $referrals = [];
        $data['reftransactions'] = array_map(function (App\Entity\Referral $referral) {
            $data['month'] = $referral->getFormattedMonth();
            $data['transtype'] = $referral->getConcept();
            $data['status'] = ucfirst($referral->getStatus());
            $data['cashback'] = sprintf('%.2f', $referral->getAmount());
            $data['date'] = $referral->getPaymentDate() ? $referral->getPaymentDate()->format('m/d/Y') : 'N/A';

            return $data;
        }, $result);

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
            $data['report_date'] = $cashback->getReportDate() ? $cashback->getReportDate()->format('m/d/Y') : null;
            $data['merchant'] = $cashback->getConcept();
            $data['order_id'] = $cashback->getOrderNumber();
            $data['status'] = ucfirst($cashback->getStatus());
            $data['amount'] = sprintf('%.2f', $cashback->getTotalPurchase());
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

        $em = $this->container['orm.em'];

        $result = $em->getRepository('App\Entity\Referral')->getMostRecentUserReferral(
            $em->getReference('App\Entity\User', $this->user_id)
        );

        $referrals = [];
        array_walk($result, function (App\Entity\Referral $referral) use (&$referrals) {
            foreach (['amount', 'direct', 'indirect'] as $field) {
                $method = 'get' . ucfirst($field);
                $value = $referral->$method();
                $referrals[] = [
                    'date' => $referral->getFormattedMonth(),
                    'level' => $field === 'amount' ? $referral->getConcept() : ($field === 'direct' ? 'Level 1' : 'Level 2-7'),
                    'status' => ucfirst($referral->getStatus()),
                    'cashback' => sprintf('%.2f', $value),
                ];
            }
        });

        $data['reftransactions'] = $referrals;
        $this->parser->parse('cashback/base', $data);
    }
}
