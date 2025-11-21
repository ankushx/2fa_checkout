<?php

namespace MiniOrange\TwoFA\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
class Trusted extends AbstractDb
{
    protected $_dateTime;
    public function __construct(Context $p6hgo, DateTime $mCrLv, $kBCCm = null)
    {
        $this->_dateTime = $mCrLv;
        parent::__construct($p6hgo, $kBCCm);
    }
    public function getExistTrusted($Yz6i3, $VONCX, $eAXzX)
    {
        $ok3UL = $this->getConnection();
        $rg9Qc = $ok3UL->select()->from($this->getMainTable(), "\164\x72\165\163\164\145\144\137\x69\144")->where("\x75\163\x65\x72\137\151\144\x20\x3d\40\72\x75\163\x65\162\x5f\151\144")->where("\156\141\155\x65\x20\75\40\72\156\x61\x6d\x65")->where("\x64\145\166\x69\x63\x65\x5f\x69\160\x20\75\x20\x3a\x64\145\x76\151\x63\x65\x5f\x69\160");
        $gmSWI = ["\x75\163\145\162\137\151\x64" => (int) $Yz6i3, "\156\x61\x6d\x65" => $VONCX, "\144\145\166\x69\x63\145\x5f\x69\160" => $eAXzX];
        return $ok3UL->fetchOne($rg9Qc, $gmSWI);
    }
    protected function _construct()
    {
        $this->_init("\115\x69\156\x69\117\162\x61\x6e\x67\x65\x5f\164\167\x6f\146\x61\x63\164\157\x72\x61\x75\x74\150\137\x74\x72\x75\x73\164\x65\144", "\x74\162\165\x73\x74\x65\144\137\151\x64");
    }
    protected function _beforeSave(AbstractModel $P65eJ)
    {
        if ($P65eJ->getCreatedAt()) {
            goto LUeQL;
        }
        $P65eJ->setCreatedAt($this->_dateTime->date());
        LUeQL:
        return $this;
    }
}