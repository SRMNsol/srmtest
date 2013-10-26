<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BeeSavy Library
 *
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		Jonny Simkin
*/

class Beesavy extends Extrabux
{
    public function getUserStats($id)
    {
        $cashback = parent::getUserStats($id);
        $total = $cashback['total'];
        $total[0]['UserPending'] = sprintf("%01.2f",(float) $total[0]['pending']);
        $total[0]['UserAvailable'] = sprintf("%01.2f",(float) $total[0]['available']);
        $total[0]['pending'] = sprintf("%01.2f",(float) $total[0]['pending']+(float) $total[0]['referralpending']);
        $total[0]['available'] = sprintf("%01.2f",(float) $total[0]['available']+(float) $total[0]['referralavailable']);
        $total[0]['processing'] = sprintf("%01.2f",(float) $total[0]['referralprocessing']+(float) $total[0]['processing']);
        $total[0]['paid'] = sprintf("%01.2f",(float) $total[0]['referralpaid']+(float) $total[0]['paid']);
        $total[0]['referralpending'] = sprintf("%01.2f",(float) $total[0]['referralpending']);
        $total[0]['referralavailable'] = sprintf("%01.2f",(float) $total[0]['referralavailable']);
        $purchases = $cashback['purchases'];
        $index= 0 ;
        for ($i = 0; $i<count($cashback['reftransactions']); $i++) {
            $sum = 0;
            $sum += (float) $cashback['reftransactions'][$i]['referralpaid'];
            $sum += (float) $cashback['reftransactions'][$i]['referralcommissiondirect'];
            $sum += (float) $cashback['reftransactions'][$i]['referralcommissionindirect'];
            if ($sum == 0) {
                unset($cashback['reftransactions'][$i]);
            }
        }

        return array_merge(array(
            'type'  => 'all',
            'total' => $total,
        ), array(
            'transactions'    => $purchases,
            'reftransactions' => $cashback['reftransactions']
        ));
    }
}
