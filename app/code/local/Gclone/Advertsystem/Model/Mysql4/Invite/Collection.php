<?php
/**
 * Author   : Contus Support
 *
 * * NOTICE OF LICENSE
 *
 * This source file is subject to the CONTUS ADVERT SYSTEM (REFER A FRIEND)
 * License, which extends the  GNU General Public License (GPL).
 * The CONTUS ADVERT SYSTEM (REFER A FRIEND) License is available at this URL:
 *      http://www.contussupport.com/magento/CONTUS-ADVERT-SYSTEM-LICENSE-COMMUNITY.txt
 *
 * DISCLAIMER
 *
 * By adding to, editing, or in any way modifying this code, CONTUS is
 * not held liable for any inconsistencies or abnormalities in the
 * behaviour of this code.
 * By adding to, editing, or in any way modifying this code, the Licensee
 * terminates any agreement of support offered by CONTUS, outlined in the
 * provided Sweet Tooth License.
 * Upon discovery of modified code in the process of support, the Licensee
 * is still held accountable for any and all billable time CONTUS spent
 * during the support process.
 * CONTUS does not guarantee compatibility with any other framework extension.
 * CONTUS is not responsbile for any inconsistencies or abnormalities in the
 * behaviour of this code if caused by other framework extension.
 * Also distributing the code is prohibited ,It is accountable if violated license agreement.
 */
/**
 * Collection of Referrer's Invites
 */
class Gclone_Advertsystem_Model_Mysql4_Invite_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Class constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('advertsystem/invite');
    }

    

    /**
     * Set up Signed Up filter
     * @return AW_Referafriend_Model_Mysql4_Invite_Collection
     */
    public function setSignupFilter()
    {
        $this->getSelect()
            ->where('main_table.referral_id > 0');
        return $this;
    }

    

    /**
     * Set up Email Filter
     * @param string $email Email
     * @return AW_Referafriend_Model_Mysql4_Invite_Collection
     */
    public function setEmailFilter($email)
    {
        $this->getSelect()
            ->where('main_table.referral_email = ?', strtolower($email));
        return $this;
    }

}