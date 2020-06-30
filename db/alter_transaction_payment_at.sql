//created column
ALTER TABLE `transaction_deposit` ADD `payment_at` timestamp after `deleted_flg`;

//get data column updated_at for payment_at 


//update table if column NOTE = null , payment_at null
UPDATE `transaction_deposit` SET `amount_pay`= NULL
WHERE `note` ='fail'

ALTER TABLE `transaction_deposit` ADD `amount_pay` int(11) after `amount`;
update `transaction_deposit` set `amount_pay`=`amount` WHERE `note` ='OK'

UPDATE `transaction_deposit` SET `amount_pay`= CAST(JSON_EXTRACT( result , '$.money') AS UNSIGNED)
