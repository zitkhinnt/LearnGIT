<?php
define("UPDATE", 1);

define("DELETED_DISABLE", 0);
define("DELETED_ENABLE", 1);

// Gender
define("MALE", 0);
define("FEMALE", 1);
define("SEX_UNKNOW", 2);

// Mail info
define("MAIL_FROM_ADDRESS", "info@kamikeirin.jp");
define("MAIL_FROM_NAME", "One and only");
define("MAIL_TITLE_CONTACT", "お問い合わせ");

// age user
define("AGE_USER_UNKNOW", 0);
define("AGE_USER_20", 20);
define("AGE_USER_30", 30);
define("AGE_USER_40", 40);
define("AGE_USER_50", 50);
define("AGE_USER_60", 60);
define("AGE_USER_70", 70);

// Mail template
define("MAIL_TEMPLATE_TYPE_REGISTER", 1);
define("MAIL_TEMPLATE_TYPE_PAYMENT", 2);
define("MAIL_TEMPLATE_TYPE_DEPOSIT", 3);
define("MAIL_TEMPLATE_TYPE_BULK", 4);
define("MAIL_TEMPLATE_TYPE_SCHEDULE", 5);
define("MAIL_TEMPLATE_TYPE_CONTACT", 6);
define("MAIL_TEMPLATE_TYPE_ORDER", 7);
define("MAIL_TEMPLATE_TYPE_FORGET_PASSWORD", 8);

// Mail send status
define("SEND_MAIL_STATUS_FAIL", 0);
define("SEND_MAIL_STATUS_SUCCESS", 1);

// Mail bulk status
define("MAIL_BULK_STATUS_NOT_SEND", 0);
define("MAIL_BULK_STATUS_SENDING", 1);
define("MAIL_BULK_STATUS_STOP", 2);
define("MAIL_BULK_STATUS_DONE", 3);

// Mail schedule type
define("MAIL_SCHEDULE_TYPE_RESERVE", 1);
define("MAIL_SCHEDULE_TYPE_WEEKLY", 2);
define("MAIL_SCHEDULE_TYPE_DAILY", 3);
define("MAIL_SCHEDULE_TYPE_MONTHLY", 4);

// properties
define("MAIL_SCHEDULE_PROPERTIES_ELAPSED", 1);
define("MAIL_SCHEDULE_PROPERTIES_DESIGNATION", 2);

// Target
define("MAIL_SCHEDULE_TARGET_REGISTER", 1);
define("MAIL_SCHEDULE_TARGET_PAYMENT", 2);
define("MAIL_SCHEDULE_TARGET_DEPOSIT", 3);
define("MAIL_SCHEDULE_TARGET_USER_INTERIM", 4);
define("MAIL_SCHEDULE_TARGET_FORGET_PASSWORD", 8);

// Mail schedule status
define("MAIL_SCHEDULE_STATUS_NOT_SEND", 0);
define("MAIL_SCHEDULE_STATUS_SEND", 1);
define("MAIL_SCHEDULE_STATUS_REMOVE", 2);

// Mail send
define("SEND_MAIL_NOT", 0);
define("SEND_MAIL_YET", 1);
define("NO_NEED_SEND_MAIL", 2);

// Mail contact
define("GUEST_0", 0);
define("GUEST_NICKNAME", "GUEST");

// Day of week
define('SUNDAY', 0);
define('MONDAY', 1);
define('TUESDAY', 2);
define('WEDNESDAY', 3);
define('THURSDAY', 4);
define('FRIDAY', 5);
define('SATURDAY', 6);

// User
define("LENGTH_LOGIN_ID", 7);
define("LENGTH_USER_KEY", 10);
define("LENGTH_PASSWORD", 10);

// User member level
define("MEMBER_LEVEL_TRIAL", 0);
define("MEMBER_LEVEL_GOLD", 1);
define("MEMBER_LEVEL_DIAMOND", 2);
define("MEMBER_LEVEL_CRYSTAL", 3);
define("MEMBER_LEVEL_EXCEPT", 4);

define("MEMBER_SPECIAL", 10);

// Gift
define("GIFT_TYPE_REGISTER", 1);
define("GIFT_TYPE_PAYMENT", 2);
define("GIFT_TYPE_DEPOSIT", 3);
define("GIFT_TYPE_PREDICTION", 4);
define("GIFT_TYPE_EVENT", 5);

// Transaction gift type
define("TRANSACTION_GIFT_TYPE_GIFT", 1);
define("TRANSACTION_GIFT_TYPE_BONUS", 2);
define("TRANSACTION_GIFT_TYPE_ENTRANCE", 3);

// Transaction status
define("TRANSACTION_STATUS_FAIL", 0);
define("TRANSACTION_STATUS_SUCCESS", 1);

// Prediction type
define("PREDICTION_TYPE_TRIAL_PACK", 1);
define("PREDICTION_TYPE_OWNERS_SECRET", 2);
define("PREDICTION_TYPE_AGENT_EYE", 3);
define("PREDICTION_TYPE_RECEPTION_RACE", 4);
define("PREDICTION_TYPE_THE_STALLION", 5);
define("PREDICTION_TYPE_GREAT_NINE", 6);
define("PREDICTION_TYPE_ONLY_ONE", 7);

// Race no
define("RACE_NO_1", 1);
define("RACE_NO_2", 2);
define("RACE_NO_3", 3);
define("RACE_NO_4", 4);
define("RACE_NO_5", 5);
define("RACE_NO_6", 6);
define("RACE_NO_7", 7);
define("RACE_NO_8", 8);
define("RACE_NO_9", 9);
define("RACE_NO_10", 10);
define("RACE_NO_11", 11);
define("RACE_NO_12", 12);

// Prediction status
define("PREDICTION_STATUS_PREPARE", 1);
define("PREDICTION_STATUS_OPEN", 2);
define("PREDICTION_STATUS_REMAIN", 3);
define("PREDICTION_STATUS_DONE", 4);

// Blog status
define("BLOG_STATUS_0", 0);
define("BLOG_STATUS_1", 1);
define("BLOG_STATUS_2", 2);
define("BLOG_STATUS_3", 3);
define("BLOG_STATUS_4", 4);
define("BLOG_STATUS_5", 5);

// Deposit method
define("METHOD_BANK", 0);
define("METHOD_CREDIT", 1);

// Status payment
define("NOT_APPLY", 0);
define("APPLY", 1);

// Buy prediction
define("NOT_BUY_PREDICTION", 0);
define("BUY_PREDICTION", 1);
define("BUY_PREDICTION_ERROR", 2);

// Paginate mail box
define("PAGINATE_MAIL_BOX", 10);
define("PAGINATE_MAIL_BOX_ADMIN", 15);

// Mail type
define('MAIL_CONTACT', 1);
define('MAIL_BULK', 2);
define('MAIL_SCHEDULE', 3);
define('MAIL_PAYMENT', 4);
define('MAIL_DEPOSIT', 5);
define('MAIL_GIFT', 6);
define('MAIL_PREDICTION_OPEN', 7);
define('MAIL_PREDICTION_RESULT', 8);
define('MAIL_REGISTER', 9);
define('MAIL_INTERIM', 10);

// Mail contact
define("MAIL_CONTACT_USER_SEND", 0);
define("MAIL_CONTACT_ADMIN_SEND", 1);

// Transaction
define("TRANSACTION_DEPOSIT", 1);
define("TRANSACTION_PAYMENT", 2);
define("TRANSACTION_GIFT", 3);

// Role
define("ROLE_PARTNER", "partner");
define("ROLE_ADMIN", "admin");
define("ROLE_STAFF", "staff");

// menu level
define("MENU_LEVEL_1", 1);
define("MENU_LEVEL_2", 2);

// menu - role - type
define("ROLE_EMAIL_HIDDEN", 0);
define("ROLE_EMAIL_SHOW", 1);


// Media
define("MEDIA_DEFAULT", "zzz");

define("SEPARATE", ",");

define("READ", 1);
define("UNREAD", 2);

// Rate amount
define("RATE_0_30", 1);
define("RATE_30_60", 2);
define("RATE_60_100", 3);
define("RATE_100", 4);

// User buy prediction
define("USER_CAN_NOT_BUY", 0);
define("USER_CAN_BUY", 1);

// User access result
define("ACCESS_RESULT_NOT_SEE", 0);
define("ACCESS_RESULT_SEE", 1);

// Search user buy prediction
define("USER_BUY_PREDICTION_SUCCESS", 1);
define("USER_BUY_PREDICTION_ERROR", 2);
define("USER_ACCESS_RESULT_SUCCESS", 3);
define("USER_ACCESS_RESULT_NOT", 4);

// Summary type
define("SUMMARY_TYPE_PAYMENT", 1);
define("SUMMARY_TYPE_NOT_PAYMENT", 2);
define("SUMMARY_TYPE_NOT_LOGIN", 3);

// File name export
define("FILE_USER_REGISTER_MAIL", "User_mail_touroku");
define("FILE_USER_INTERIM_MAIL", "User_mail_karitouroku");

// Entrance default
define("ENTRANCE_DEFAULT_DISABLE", 0);
define("ENTRANCE_DEFAULT_ENABLE", 1);

// Name entrance gift point
define("NAME_GIFT_ENTRANCE", "入口設定により追加");

// JWT
define("JWT_EXPIRATION", 604800);
define("JWT_SECRET", "w2Sce13R4z24gJDDs1x321321sadsa");
define("NOT_SAVE_INFO_DEPOSIT", 0);
define("SAVE_INFO_DEPOSIT", 1);

// Telecom credit setting
//define("CLIENT_ID", 72655);
define("CLIENT_ID", '');

// Mail register
define("MAIL_BOX","pop21.gmoserver.jp");// "pop21.gmoserver.jp");
define("REGISTER_USERNAME", "info@kamikeirin.jp");//"info1@kamikeirin.jp");
define("REGISTER_PASSWORD","NwYW#5hp");//"kamiwido123#");

// Mail contact
define("CONTACT_USERNAME", "info@kamikeirin.jp");// "info1@kamikeirin.jp");
define("CONTACT_PASSWORD", "NwYW#5hp___");//"kamiwido123#");

// Billing flg
define("BILLING_FLG_DISABLE", 0);
define("BILLING_FLG_ENABLE", 1);

// User stage
define("USER_STAGE_MATCH", 1);
define("USER_STAGE_EXCLUSION", 2);

// User Match Status
define("USER_STAGE_MATCH_ALL", 1);
define("USER_STAGE_MATCH_PORTION", 0);

// Stop mail
define("STOP_MAIL_DISABLE", 0);
define("STOP_MAIL_ENABLE", 1);

// PREDICTION POINT
define("PRE_60", 60);
define("PRE_120", 120);
define("PRE_300", 300);
define("PRE_500", 500);
define("PRE_1000", 1000);
define("PRE_2000", 2000);
define("PRE_3000", 3000);

// course
define("COURSE_1ST", 1);
define("COURSE_2ND", 2);
define("COURSE_3RD", 3);
define("COURSE_4TH", 4);
define("COURSE_5TH", 5);

//double

define("DOUBLE_ON", 1);
define("DOUBLE_OFF", 0);

// ticket_type

define("TICKET_TYPE_1", 1);
define("TICKET_TYPE_2", 2);
define("TICKET_TYPE_3", 3);

// Result
define("LIMIT_RESULT", 30);
define("PAGINATE_RESULT", 6);

// image_frontend
define('IMAGE_FRONTEND_CODE_ATTENTION', 'attention');

// prediction type code
define("PREDICTION_TYPE_CODE_C1", 'c_1');
define("PREDICTION_TYPE_CODE_C2", 'c_2');
define("PREDICTION_TYPE_CODE_C3", 'c_3');
define("PREDICTION_TYPE_CODE_C4", 'c_4');
define("PREDICTION_TYPE_CODE_C5", 'c_5');
define("PREDICTION_TYPE_CODE_C6", 'c_6');
define("PREDICTION_TYPE_CODE_C7", 'c_7');
define("PREDICTION_TYPE_CODE_C8", 'c_8');
define("PREDICTION_TYPE_CODE_C9", 'c_9');
define("PREDICTION_TYPE_CODE_C10", 'c_10');

// prediction type denomination
define("PREDICTION_TYPE_DENOMINATION_1", '2車単');
define("PREDICTION_TYPE_DENOMINATION_2", '3連単');
define("PREDICTION_TYPE_DENOMINATION_3", '3連複');

// prediction type content
define("PREDICTION_TYPE_CONTENT_CONTENT", 'content');
define("PREDICTION_TYPE_CONTENT_AFTER_BUY", 'after_buy');
define("PREDICTION_TYPE_CONTENT_RESULT", 'result');

// sns register type
define("SNS_REGISTER_TYPE_ALL", 'all');
define("SNS_REGISTER_TYPE_GOOGLE", 'google');
define("SNS_REGISTER_TYPE_TWITTER", 'twitter');
define("SNS_REGISTER_TYPE_YAHOO", 'yahoo');
define("SNS_REGISTER_TYPE_FACEBOOK", 'facebook');

//Ad Type
define("ADVERTISE_TYPE_AF", 0);
define("ADVERTISE_TYPE_SHARE", 1);
define("ADVERTISE_TYPE_PERMANENT", 2);