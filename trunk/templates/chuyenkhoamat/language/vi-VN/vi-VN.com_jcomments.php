<?php
//
// jComments frontend constants
//

// mambot (blog links)
DEFINE('_JCOMMENTS_COUNT',                        'Comments');
DEFINE('_JCOMMENTS_WRITE',                        'Thêm nhận xét mới');
DEFINE('_JCOMMENTS_READMORE',                     'More...');
DEFINE('_JCOMMENTS_HITS',                         'Hits');
DEFINE('_JCOMMENTS_FOR_SECTION',                  'for section');
DEFINE('_JCOMMENTS_COMMENTS_FOR',                 'Discuss ');

// comments list
DEFINE('_JCOMMENTS_HEADER',                       'Nhận xét');
DEFINE('_JCOMMENTS_CODE',                         'Code:');
DEFINE('_JCOMMENTS_WROTE',                        'says:');
DEFINE('_JCOMMENTS_QUOTE_SINGLE',                 'Quote:');
DEFINE('_JCOMMENTS_QUOTE_PREFIX',                 'Quoting ');
DEFINE('_JCOMMENTS_QUOTE_SUFFIX',                 ': ');
DEFINE('_JCOMMENTS_RSS',                          'RSS feed for comments to this post.');
DEFINE('_JCOMMENTS_REFRESH', 			  'Refresh comments list');

// toolbar
DEFINE('_JCOMMENTS_EDIT',                         'Thay đổi');
DEFINE('_JCOMMENTS_DELETE',                       'Xóa');
DEFINE('_JCOMMENTS_CONFIRM_DELETE',               'Xóa nhận xét này?');
DEFINE('_JCOMMENTS_PUBLISH',                      'Công khai');
DEFINE('_JCOMMENTS_UNPUBLISH',                    'Ản');
DEFINE('_JCOMMENTS_QUOTE',                        'Quoting');
DEFINE('_JCOMMENTS_IP',                           'Xem IP');
DEFINE('_JCOMMENTS_EMAIL',                        'Write e-mail');
DEFINE('_JCOMMENTS_HOMEPAGE',                     'Trang chủ');

// comments form
DEFINE('_JCOMMENTS_FORM_HEADER',                  'Thêm nhận xét');
DEFINE('_JCOMMENTS_FORM_SEND',                    'Gửi hoặc bấm (Ctrl+Enter)');
DEFINE('_JCOMMENTS_FORM_NAME',                    'Tên (required)');
DEFINE('_JCOMMENTS_FORM_EMAIL',                   'E-Mail');
DEFINE('_JCOMMENTS_FORM_EMAIL_REQUIRED',          'E-Mail (required)');
DEFINE('_JCOMMENTS_FORM_HOMEPAGE',                'Site');
DEFINE('_JCOMMENTS_FORM_HOMEPAGE_REQUIRED',       'Site (required)');
DEFINE('_JCOMMENTS_FORM_CHARSLEFT_PREFIX',        '');
DEFINE('_JCOMMENTS_FORM_CHARSLEFT_SUFFIX',        ' Ký từ còn lại');
DEFINE('_JCOMMENTS_FORM_CAPTCHA',                 'Mã bảo mật');
DEFINE('_JCOMMENTS_FORM_CAPTCHA_REFRESH', 	  'Làm tươi');
DEFINE('_JCOMMENTS_FORM_CAPTCHA_NOTE', 		  'Nếu bạn không thể xem được mã bảo mật, hãy bấm Refresh.');
DEFINE('_JCOMMENTS_FORM_TRANSLIT',                'Auto transliteration:');
DEFINE('_JCOMMENTS_FORM_TRANSLIT_OFF',            'Tắt');
DEFINE('_JCOMMENTS_FORM_TRANSLIT_ON',             'Bật');
DEFINE('_JCOMMENTS_FORM_SAVE',                    'Lưu');
DEFINE('_JCOMMENTS_FORM_CANCEL',                  'Hủy');
DEFINE('_JCOMMENTS_FORM_SUBSCRIBE', 		  'Thông báo cho tôi.');

// BBCode buttons
DEFINE('_JCOMMENTS_FORM_BBCODE_B',                 'Đậm');
DEFINE('_JCOMMENTS_FORM_BBCODE_I',                 'Nghiêng');
DEFINE('_JCOMMENTS_FORM_BBCODE_U',                 'Gạch dưới');
DEFINE('_JCOMMENTS_FORM_BBCODE_S',                 'Striked');
DEFINE('_JCOMMENTS_FORM_BBCODE_URL',               'Link');
DEFINE('_JCOMMENTS_FORM_BBCODE_IMG',               'Ảnh');
DEFINE('_JCOMMENTS_FORM_BBCODE_QUOTE',             'Quote');
DEFINE('_JCOMMENTS_FORM_BBCODE_LIST',              'List');
DEFINE('_JCOMMENTS_FORM_BBCODE_HIDE',              'Hidden text (only for registered)');

// administrator notification
DEFINE('_JCOMMENTS_NOTIFICATION_SUBJECT_NEW',      'Đã thêm nhận xét');
DEFINE('_JCOMMENTS_NOTIFICATION_SUBJECT_UPDATED',  'Thay đổi thành công');
DEFINE('_JCOMMENTS_NOTIFICATION_COMMENT_TITLE',    'Content item title');
DEFINE('_JCOMMENTS_NOTIFICATION_COMMENT_LINK',     'Content item link');
DEFINE('_JCOMMENTS_NOTIFICATION_COMMENT_DATE',     'Date of addition');
DEFINE('_JCOMMENTS_NOTIFICATION_COMMENT_NAME',     'Người gửi');
DEFINE('_JCOMMENTS_NOTIFICATION_COMMENT_EMAIL',    'Author E-mail');
DEFINE('_JCOMMENTS_NOTIFICATION_COMMENT_HOMEPAGE', 'Author site');
DEFINE('_JCOMMENTS_NOTIFICATION_COMMENT_TEXT',     'Comment text');
DEFINE('_JCOMMENTS_NOTIFICATION_COMMENT_UNSUBSCRIBE', 'This message was addressed to you because you wished to be advised new comments related to &laquo;%s&raquo;. You can stop subscribing yourselves while clicking on the link below');

// common messages
DEFINE('_JCOMMENTS_THANKS',                        'Thanks for your comments. They will be reviewed by an administrator prior to being published!');
DEFINE('_JCOMMENTS_HIDDEN_TEXT',                   'Only registered users can view hidden text!');

// common error messages
DEFINE('_JCOMMENTS_ERROR_EMPTY_NAME',              'Vui lòng điền tên của bạn');
DEFINE('_JCOMMENTS_ERROR_NAME_EXISTS',             'This name is already in use. Please login or try to use another name.');
DEFINE('_JCOMMENTS_ERROR_FORBIDDEN_NAME',          "Specified name is located in the list of forbidden words.\nPlease try to use another name.");
DEFINE('_JCOMMENTS_ERROR_INVALID_NAME',            "This name consists of forbidden symbols.\nPlease do not use quotation marks or square brackets [ and ] in the name");
DEFINE('_JCOMMENTS_ERROR_TOO_LONG_COMMENT',        'Nhận xét quá dài!');
DEFINE('_JCOMMENTS_ERROR_TOO_SHORT_COMMENT',       'Your message consists only of a quote of another comment. May be you forgot to comment this quote?');
DEFINE('_JCOMMENTS_ERROR_TOO_LONG_USERNAME',       'Tài khoản không hợp lệ!');
DEFINE('_JCOMMENTS_ERROR_TOO_QUICK',               'You have recently added a new comment, please try again later.');
DEFINE('_JCOMMENTS_ERROR_NOTHING_TO_QUOTE',        'There is no text for quoting!');
DEFINE('_JCOMMENTS_ERROR_EMPTY_EMAIL',             'Please enter e-mail');
DEFINE('_JCOMMENTS_ERROR_INCORRECT_EMAIL',         'Please enter valid e-mail');
DEFINE('_JCOMMENTS_ERROR_EMPTY_HOMEPAGE',          'Please enter site URL');
DEFINE('_JCOMMENTS_ERROR_EMPTY_COMMENT',           'Please enter text of your comment');
DEFINE('_JCOMMENTS_ERROR_CAPTCHA',                 'Please enter security code displayed on the image');
DEFINE('_JCOMMENTS_ERROR_DUPLICATE_COMMENT',       'You have already posted the same comment.');
DEFINE('_JCOMMENTS_ERROR_CANT_COMMENT',            'You have no rights to add a new comment. May be you need to register on the site.');
DEFINE('_JCOMMENTS_ERROR_CANT_DELETE',             'You have no rights to delete messages.');
DEFINE('_JCOMMENTS_ERROR_CANT_PUBLISH',            'You have no rights for publishing comments.');
DEFINE('_JCOMMENTS_ERROR_CANT_EDIT',               'You have no rights for editing comments.');
DEFINE('_JCOMMENTS_ERROR_TRANSLIT_NOT_SUPPORTED',  'Sorry, but your browser is not supported by transliteration function');
DEFINE('_JCOMMENTS_ERROR_BEING_EDITTED',           'This comment is currently being edited by another person');
DEFINE('_JCOMMENTS_ERROR_NOT_FOUND',               "Can't find comment message!\n May be it has been deleted or unpublished by administrator.");

//
// JComments backend constants
//

// common backend constants
DEFINE('_JCOMMENTS_A_SAVE',                        'Save');
DEFINE('_JCOMMENTS_A_ENABLE',                      'Enable');
DEFINE('_JCOMMENTS_A_UNREQUIRED',                  'Unrequired');
DEFINE('_JCOMMENTS_A_REQUIRED_FOR_ALL',            'Required for all');
DEFINE('_JCOMMENTS_A_REQUIRED_FOR_UNREGISTERED',   'Required only for guests');
DEFINE('_JCOMMENTS_A_DISABLE',                     'Disable');
DEFINE('_JCOMMENTS_A_YES',                         'Yes');
DEFINE('_JCOMMENTS_A_NO',                          'No');
DEFINE('_JCOMMENTS_A_COMPONENT', 		   'Component');
DEFINE('_JCOMMENTS_A_FILTER', 			   'Filter');
DEFINE('_JCOMMENTS_A_FILTER_ALL_COMPONENTS', 	   '- Select component -');
DEFINE('_JCOMMENTS_A_FILTER_ALL_AUTHORS', 	   '- Select author -');
DEFINE('_JCOMMENTS_A_PUBLISHING', 		   'Publishing');

// jComments settings page
DEFINE('_JCOMMENTS_A_SETTINGS',                    'Configuration');
DEFINE('_JCOMMENTS_AE_SETTINGS_SAVED',             'Configuration has been successfully saved!');
DEFINE('_JCOMMENTS_AE_SETTINGS_SAVE_ERROR',        'Error occured while writing configuration file!');

// Settings/Common
DEFINE('_JCOMMENTS_A_COMMON',                      'General');
DEFINE('_JCOMMENTS_A_COMMON_NOTE',                 'General parameters');

DEFINE('_JCOMMENTS_AP_ENABLE_TRANSLIT',            'Translit');
DEFINE('_JCOMMENTS_AP_ENABLE_TRANSLIT_NOTE',       'Enable/Disable transliteration function. Given function allows you to automatically recode submitted message into cyrilic.');
DEFINE('_JCOMMENTS_AP_USERNAME_MAXLENGTH',         'Max. length of username');
DEFINE('_JCOMMENTS_AP_USERNAME_MAXLENGTH_NOTE',    'Maximum length of username. On exceeding this limit user will get alert window. By default, &mdash; 20 symbols.');
DEFINE('_JCOMMENTS_AP_COMMENT_MAXLENGTH',          'Max. length of message');
DEFINE('_JCOMMENTS_AP_COMMENT_MAXLENGTH_NOTE',     'Maximum length of comment message. On exceeding this limit user will get alert window. By default, &mdash; 1000 symbols.');
DEFINE('_JCOMMENTS_AP_WORD_MAXLENGTH',             'Max. length of word');
DEFINE('_JCOMMENTS_AP_WORD_MAXLENGTH_NOTE',        'Enables auto breaking of words into parts if symbols quantity has exceeded length limit. By default, &mdash; 15 symbols.');
DEFINE('_JCOMMENTS_AP_LINK_MAXLENGTH',             'Max. length of URL');
DEFINE('_JCOMMENTS_AP_LINK_MAXLENGTH_NOTE',        'If length of link has exceeded specified length limit then this URL will be splitted by line feeds. By default, &mdash; 30 symbols.');
DEFINE('_JCOMMENTS_AP_FLOOD_TIME',                 'Time interval between messages, sec.');
DEFINE('_JCOMMENTS_AP_FLOOD_TIME_NOTE',            'Defines minimal time gap between two sequenced comments. This parameter sets only time interval. To apply this option you have to enable flood control protection for selected user group(s) on &laquo;Permissions&raquo; tab.');
DEFINE('_JCOMMENTS_AP_ENABLE_USERNAME_CHECK',      'Check names');
DEFINE('_JCOMMENTS_AP_ENABLE_USERNAME_CHECK_NOTE', 'Enable/Disable checking for using already registered usernames by unauthorized users.');
DEFINE('_JCOMMENTS_AP_AUTHOR_EMAIL',               'Field &laquo;E-mail&raquo;');
DEFINE('_JCOMMENTS_AP_AUTHOR_EMAIL_NOTE',          'This parameter controls displaying and fill checking of the &laquo;E-mail&raquo; field (it makes sense only for unauthorized users).');
DEFINE('_JCOMMENTS_AP_AUTHOR_HOMEPAGE',            'Field &laquo;site URL&raquo;');
DEFINE('_JCOMMENTS_AP_AUTHOR_HOMEPAGE_NOTE',       'Allows to control displaying and fill checking of the &laquo;site URL&raquo; field (web site link of comment\'s author).');

DEFINE('_JCOMMENTS_AP_ENABLE_NOTIFICATION',             'Enable notification');
DEFINE('_JCOMMENTS_AP_ENABLE_NOTIFICATION_NOTE',        'Enable/Disable sending notifications to administrators about adding/changing comments by users.');
DEFINE('_JCOMMENTS_AP_ENABLE_NOTIFICATION_EMAIL',       'E-mail for notification');
DEFINE('_JCOMMENTS_AP_ENABLE_NOTIFICATION_EMAIL_NOTE',  'Defines E-mail for sending notifications about new messages. You can list more than one address separated by a comma.');
DEFINE('_JCOMMENTS_AP_FORBIDDEN_NAMES_LIST',            'List of forbidden names');
DEFINE('_JCOMMENTS_AP_FORBIDDEN_NAMES_LIST_NOTE',       'List of forbidden usernames (you can specify them via comma or write every name starting from new line). It could be very usefull to list names which are similar to already registered usernames.');

// Settings/View
DEFINE('_JCOMMENTS_A_VIEW',                         'View');
DEFINE('_JCOMMENTS_A_VIEW_NOTE',                    'Parameters for configuration of comment appearance');

DEFINE('_JCOMMENTS_AP_TEMPLATE',                    'Template');
DEFINE('_JCOMMENTS_AP_TEMPLATE_NOTE',               'Template for displaying comments. Helping with template you can change front-end appearance of comments.<br />Folder with templates is here: /components/com_jcomments/tpl/');
DEFINE('_JCOMMENTS_AP_ENABLE_SMILES',               'Using smiles');
DEFINE('_JCOMMENTS_AP_ENABLE_SMILES_NOTE',          'Enable/Disable graphic smiles in messages.');
DEFINE('_JCOMMENTS_AP_COMMENTS_PER_PAGE',           'Comments per page');
DEFINE('_JCOMMENTS_AP_COMMENTS_PER_PAGE_NOTE',      'Number of messages displayed per one page. To disable pagination set the value to 0.');
DEFINE('_JCOMMENTS_AP_COMMENTS_PAGE_LIMIT',         'Maximum number of pages');
DEFINE('_JCOMMENTS_AP_COMMENTS_PAGE_LIMIT_NOTE',    'This option will cause limited pagination. When using it you can increase value of &laquo;Comments per page&raquo; parameter to avoid this limit. By default, &mdash; 15;');
DEFINE('_JCOMMENTS_AP_PAGINATION',                  'Page numbers position');
DEFINE('_JCOMMENTS_AP_PAGINATION_NOTE',             'This option defines where to show list of page numbers. By default, page numbers are displayed on top and at the bottom.');
DEFINE('_JCOMMENTS_AP_PAGINATION_TOP',              'Top');
DEFINE('_JCOMMENTS_AP_PAGINATION_BOTTOM',           'Bottom');
DEFINE('_JCOMMENTS_AP_PAGINATION_BOTH',             'Top and Bottom');
DEFINE('_JCOMMENTS_AP_ORDER',                       'Order');
DEFINE('_JCOMMENTS_AP_ORDER_NOTE',                  'Displaying order of comments. By default, new messages are shown first.');
DEFINE('_JCOMMENTS_AP_ORDER_ASC',                   'Last at bottom');
DEFINE('_JCOMMENTS_AP_ORDER_DESC',                  'Last on top');
DEFINE('_JCOMMENTS_AP_SHOW_COMMENTLENGTH',          'Show symbols counter');
DEFINE('_JCOMMENTS_AP_SHOW_COMMENTLENGTH_NOTE',     'Enable/Disable displaying counter of symbols quantity in message.');
DEFINE('_JCOMMENTS_AP_ENABLE_NESTED_QUOTES',        'Enable enclosed quotes');
DEFINE('_JCOMMENTS_AP_ENABLE_NESTED_QUOTES_NOTE',   'Enable/Disable enclosed quotes in messages. Disabling this will cause auto deletion of all the enclosed blocks of quotes and leaving only author\'s quote. ');
DEFINE('_JCOMMENTS_AP_ENABLE_RSS',                  'Enable RSS feeds');
DEFINE('_JCOMMENTS_AP_ENABLE_RSS_NOTE',             'Enable/Disable RSS feeds for comments.');

// Settings/Categories
DEFINE('_JCOMMENTS_A_CATEGORIES',                   'Categories');
DEFINE('_JCOMMENTS_A_CATEGORIES_NOTE',              'Configuration of categories for using comments');

DEFINE('_JCOMMENTS_AP_CATEGORIES',                  'Choose in which categories comments will work:');
DEFINE('_JCOMMENTS_AP_CATEGORIES_NOTE',             'Select/Deselect categories in which you want to enable/disable comments. <br />(use &lt;Ctrl&gt;+left mouse button for multiple selection or deselection)<br /><br />By default no one of categories is selected, i.e. comments are disabled.<br /><br />If you would like to disable comments for specified content item then you need to <br />write a special tag {jcomments off} within a text of this material.');

// Settings/Censor
DEFINE('_JCOMMENTS_A_CENSOR',                       'Filter');
DEFINE('_JCOMMENTS_A_CENSOR_NOTE',                  'Configuration of auto replacement of unprintable words');

DEFINE('_JCOMMENTS_AP_BAD_WORDS_LIST',              'List of unprintable words');
DEFINE('_JCOMMENTS_AP_BAD_WORDS_LIST_NOTE',         'List of unprintable words, which will be automatically replaced in messages with specified word. You can separate words by comma or space or start every word at new line.');
DEFINE('_JCOMMENTS_AP_CENSOR_REPLACE_WORD',         'Word for replacement');
DEFINE('_JCOMMENTS_AP_CENSOR_REPLACE_WORD_NOTE',    'A word for which will be automatically replaced all specified unprintable words in list.');

// Settings/Rigths
DEFINE('_JCOMMENTS_A_RIGHTS',                       'Permissions');
DEFINE('_JCOMMENTS_A_RIGHTS_NOTE',                  'Configuration of permissions for selected user group');
DEFINE('_JCOMMENTS_A_RIGHTS_GROUP_NOTE',            'Permissions configuration for user group: ');

DEFINE('_JCOMMENTS_A_RIGHTS_GROUPS',                'User groups');

DEFINE('_JCOMMENTS_A_RIGHTS_POST',                       'New messages');
DEFINE('_JCOMMENTS_AP_CAN_COMMENT',                      'Allow adding new comments');
DEFINE('_JCOMMENTS_AP_CAN_COMMENT_NOTE',                 'Enable/Disable adding new comments for selected user group.');
DEFINE('_JCOMMENTS_AP_AUTOPUBLISH',                      'Autopublishing');
DEFINE('_JCOMMENTS_AP_AUTOPUBLISH_NOTE',                 'Enable/Disable autopublishing submitted comments for selected user group.');
DEFINE('_JCOMMENTS_AP_ENABLE_CAPTCHA',                   'Enable CAPTCHA');
DEFINE('_JCOMMENTS_AP_ENABLE_CAPTCHA_NOTE',              'Enable/Disable spambot protection (CAPTCHA). Enabling this option will force users to enter image security code when adding new comment.');
DEFINE('_JCOMMENTS_AP_ENABLE_FLOODPROTECTION',           'Flood protection');
DEFINE('_JCOMMENTS_AP_ENABLE_FLOODPROTECTION_NOTE',      'Enable/Disable flood protection. Enabling this option will preserve user from adding comments more often than it is specified in the &amp;laquo;Time interval between messages&amp;raquo; parameter');
DEFINE('_JCOMMENTS_AP_ENABLE_AUTOCENSOR',                'Filter unprintable words');
DEFINE('_JCOMMENTS_AP_ENABLE_AUTOCENSOR_NOTE',           'Enable/Disable auto filtering of unprintable words.');
DEFINE('_JCOMMENTS_AP_ENABLE_COMMENT_LENGTH_CHECK',      'Limit length of message');
DEFINE('_JCOMMENTS_AP_ENABLE_COMMENT_LENGTH_CHECK_NOTE', 'Enable/Disable message length (in symbols) limitation.');
DEFINE('_JCOMMENTS_AP_SHOW_POLICY',                      'Show policies');
DEFINE('_JCOMMENTS_AP_SHOW_POLICY_NOTE',                 'Enable/Disable displaying policy rules for adding comments');
DEFINE('_JCOMMENTS_AP_ENABLE_SUBSCRIBE', 		 'Subscription to new comments');
DEFINE('_JCOMMENTS_AP_ENABLE_SUBSCRIBE_NOTE', 		 'Show &laquo;Notify me of follow-up comments&raquo;');

// Settings/Rights/Edit
DEFINE('_JCOMMENTS_A_RIGHTS_EDIT',                   'Editing messages');

DEFINE('_JCOMMENTS_AP_CAN_EDIT_OWN',                 'Edit own messages');
DEFINE('_JCOMMENTS_AP_CAN_EDIT_OWN_NOTE',            'Enable/Disable users in selected group to editing their own messages.');
DEFINE('_JCOMMENTS_AP_CAN_DELETE_OWN',               'Delete own messages');
DEFINE('_JCOMMENTS_AP_CAN_DELETE_OWN_NOTE',          'Enable/Disable users in selected group to deleting their own messages.');

// Settings/Rights/View
DEFINE('_JCOMMENTS_A_RIGHTS_VIEW',                   'Display');

DEFINE('_JCOMMENTS_AP_ENABLE_AUTOLINKURLS',          'URL recognition');
DEFINE('_JCOMMENTS_AP_ENABLE_AUTOLINKURLS_NOTE',     'Enable/Disable automatic link recognition whithin the comment text. Enabling this option will show URL as clickable HTML-link.');
DEFINE('_JCOMMENTS_AP_ENABLE_EMAILPROTECTION',       'Spambot E-mail protection');
DEFINE('_JCOMMENTS_AP_ENABLE_EMAILPROTECTION_NOTE',  'Enable/Disable using spambot deception function. If on, then symbol @ in email-addresses will be replaced by the picture and real address will be acceptable only after link clicking.');
DEFINE('_JCOMMENTS_AP_ENABLE_GRAVATAR', 	     'Show Gravatar');
DEFINE('_JCOMMENTS_AP_ENABLE_GRAVATAR_NOTE', 	     'Enable/Disable displaying GRAVATAR\'s');
DEFINE('_JCOMMENTS_AP_CAN_VIEW_AUTHOR_IP',           'Show IP');
DEFINE('_JCOMMENTS_AP_CAN_VIEW_AUTHOR_IP_NOTE',      'Enable/Disable displaying IP filed in comments.');
DEFINE('_JCOMMENTS_AP_CAN_VIEW_AUTHOR_EMAIL',        'Field &laquo;E-mail&raquo;');
DEFINE('_JCOMMENTS_AP_CAN_VIEW_AUTHOR_EMAIL_NOTE',   'Enable/Disable displaying e-mail field of message author.');
DEFINE('_JCOMMENTS_AP_CAN_VIEW_AUTHOR_HOMEPAGE',     'Field &laquo;site URL&raquo;');
DEFINE('_JCOMMENTS_AP_CAN_VIEW_AUTHOR_HOMEPAGE_NOTE','Enable/Disable displaying authors\' home pages.');

// Settings/Rights/Administration
DEFINE('_JCOMMENTS_A_RIGHTS_ADMINISTRATION',         'Administration rights');

DEFINE('_JCOMMENTS_AP_CAN_PUBLISH',                  'Allow publishing any comments');
DEFINE('_JCOMMENTS_AP_CAN_PUBLISH_NOTE',             'Enable/Disable publishing any comments for selected user group.');
DEFINE('_JCOMMENTS_AP_CAN_EDIT',                     'Allow editing of any comments');
DEFINE('_JCOMMENTS_AP_CAN_EDIT_NOTE',                'Enable/Disable editing comments for selected user group.');
DEFINE('_JCOMMENTS_AP_CAN_DELETE',                   'Allow delete any comments');
DEFINE('_JCOMMENTS_AP_CAN_DELETE_NOTE',              'Enable/Disable deleting comments for selected user group.');

// Settings/Rights/BBCode
DEFINE('_JCOMMENTS_A_RIGHTS_BBCODE',                 'Enable BBCode elements');

DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_B',              'Element <b>B</b> (bold)');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_B_NOTE',         'Enable/Disable using of B element (bold).');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_I',              'Element <b>I</b> (italic)');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_I_NOTE',         'Enable/Disable using of I element (italic).');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_U',              'Element <b>U</b> (underline)');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_U_NOTE',         'Enable/Disable using of U element (underline).');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_S',              'Element <b>S</b> (striked)');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_S_NOTE',         'Enable/Disable using of S element (striked).');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_URL',            'Element <b>URL</b> (link)');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_URL_NOTE',       'Enable/Disable using of URL element (link).');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_IMG',            'Element <b>IMG</b> (image)');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_IMG_NOTE',       'Enable/Disable using of IMG element (image).');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_LIST',           'Element <b>LIST</b> (listing)');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_LIST_NOTE',      'Enable/Disable using of LIST element (listing).');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_HIDE',           'Element <b>HIDE</b> (hidden text)');
DEFINE('_JCOMMENTS_AP_ENABLE_BBCODE_HIDE_NOTE',      'Enable/Disable using of HIDE element (hidden text).');

// Settings/Smiles
DEFINE('_JCOMMENTS_A_SMILES',                        'Smiles');
DEFINE('_JCOMMENTS_A_SMILES_NOTE',                   'Smiles list configuration');

DEFINE('_JCOMMENTS_A_SMILES_ADD',                    'Add smile');
DEFINE('_JCOMMENTS_A_SMILES_DELETE',                 'Delete');
DEFINE('_JCOMMENTS_A_SMILES_MOVE_UP',                'Move up');
DEFINE('_JCOMMENTS_A_SMILES_MOVE_DOWN',              'Move down');
DEFINE('_JCOMMENTS_A_SMILES_REPLACE_WITH',           'change to');
DEFINE('_JCOMMENTS_A_SMILES_UPLOAD', 		     'Upload');
DEFINE('_JCOMMENTS_A_SMILES_UPLOAD_NOTE', 	     'Upload smiles');
DEFINE('_JCOMMENTS_A_SMILES_UPLOAD_SUCCESS', 	     'Success');
DEFINE('_JCOMMENTS_A_SMILES_UPLOAD_FAIL', 	     'Failed');
DEFINE('_JCOMMENTS_A_SMILES_SELECT_FILE', 	     'Select file');

// Settings/Messages
DEFINE('_JCOMMENTS_A_MESSAGES',                            'Policies');
DEFINE('_JCOMMENTS_A_MESSAGES_NOTE',                       'Configuration of policy text which are shown to users');
DEFINE('_JCOMMENTS_A_MESSAGES_POLICY_POST',                'Policy rules for adding comments.');
DEFINE('_JCOMMENTS_A_MESSAGES_POLICY_POST_NOTE',           'Comment publishing policies for this site (html can be used). <br />If not defined user will see nothing.');
DEFINE('_JCOMMENTS_A_MESSAGES_POLICY_WHOCANCOMMENT',       'Message if user has no rights to leave comments.');
DEFINE('_JCOMMENTS_A_MESSAGES_POLICY_WHOCANCOMMENT_NOTE',  'Message text which will be displayed if user has no rights to add comments. By default:<br /><br />&laquo;%s&raquo;');

// JComment/Import
DEFINE('_JCOMMENTS_A_IMPORT',                              'Comments import');

DEFINE('_JCOMMENTS_A_IMPORT_SELECT_SOURCE',                'Choose component to import data from');
DEFINE('_JCOMMENTS_A_IMPORT_COMPONENT_NOT_INSTALLED',      'not installed');
DEFINE('_JCOMMENTS_A_IMPORT_COMPONENT_AUTHOR',             'Credits:');
DEFINE('_JCOMMENTS_A_IMPORT_COMPONENT_HOMEPAGE',           'Official home page:');
DEFINE('_JCOMMENTS_A_IMPORT_COMPONENT_LICENSE',            'License:');
DEFINE('_JCOMMENTS_A_IMPORT_COMPONENT_COMMENTS_COUNT',     'Comments quantity:');
DEFINE('_JCOMMENTS_A_IMPORT_DO_IMPORT',                    'To import');
DEFINE('_JCOMMENTS_A_IMPORT_DONE',                         'Importing completed successfully! Imported %d comments.');
DEFINE('_JCOMMENTS_A_IMPORT_FAILED',                       'Data importing failed. Please contact to developer.');

// jComments about
DEFINE('_JCOMMENTS_AI_ABOUT_LOGO_DESIGN',                  'Logo designing');
DEFINE('_JCOMMENTS_AI_ABOUT_TESTERS',                      'Beta-testers team');
DEFINE('_JCOMMENTS_AI_ABOUT_TRANSLATORS',                  'Translators');

// jComments install language constants
DEFINE('_JCOMMENTS_AI_MENU_COMMENTS',                      'Manage comments');
DEFINE('_JCOMMENTS_AI_MENU_SETTINGS',                      'Configuration');
DEFINE('_JCOMMENTS_AI_MENU_SMILES',                        'Smiles');
DEFINE('_JCOMMENTS_AI_MENU_IMPORT',                        'Import data');
DEFINE('_JCOMMENTS_AI_MENU_ABOUT',                         'Component info');

DEFINE('_JCOMMENTS_AI_LOG',                                'Installation process');
DEFINE('_JCOMMENTS_AI_WARNINGS',                           'Warnings');
DEFINE('_JCOMMENTS_AI_NEXT',                               'Next');
DEFINE('_JCOMMENTS_AI_OK',                                 'OK');
DEFINE('_JCOMMENTS_AI_ERROR',                              'Error');
DEFINE('_JCOMMENTS_AI_INSTALL_CONTENTBOT',                 'Installation of mambot jcomments.contentbot');
DEFINE('_JCOMMENTS_AI_INSTALL_CONTENTBOT_WARNING',         'Error occured while copying mambot\'s files <font color="green">jcomments.contentbot</font>.<br />You need to do manual copy of all files from <font color="green">/administrator/components/com_jcomments/mambots/content/</font> to <font color="green">/mambots/content/</font>');
DEFINE('_JCOMMENTS_AI_INSTALL_CONTENTSEARCHBOT',           'Installation of mambot jcomments.contentsearchbot');
DEFINE('_JCOMMENTS_AI_INSTALL_CONTENTSEARCHBOT_WARNING',   'Error occured while copying mambot\'s files <font color="green">jcomments.contentsearchbot</font>.<br />You need to do manual copy of all files from <font color="green">/administrator/components/com_jcomments/mambots/search/</font> to <font color="green">/mambots/search/</font>');
DEFINE('_JCOMMENTS_AI_INSTALL_SYSTEMBOT',                  'Installation of mambot jcomments.systembot');
DEFINE('_JCOMMENTS_AI_INSTALL_SYSTEMBOT_WARNING',          'Error occured while copying mambot\'s files <font color="green">jcomments.systembot</font>.<br />You need to do manual copy of all files from <font color="green">/administrator/components/com_jcomments/mambots/system/</font> to <font color="green">/mambots/system/</font>');
DEFINE('_JCOMMENTS_AI_UPDATE_MENU_ICONS',                  'Updating of menu icons');
DEFINE('_JCOMMENTS_AI_UPGRADE_TABLES',                     'Updating of DB tables structure');
DEFINE('_JCOMMENTS_AI_INSTALLED',                          'Installation completed');

// 1.4.0.8
DEFINE('_JCOMMENTS_AP_FORM', 'Form');
DEFINE('_JCOMMENTS_AP_FORM_SHOW_FROM', 'Xem');
DEFINE('_JCOMMENTS_AP_FORM_SHOW_LINK', 'Ẩn');
DEFINE('_JCOMMENTS_AP_FORM_SHOW_NOTE', 'Show/Hide comment form. If you choose Hide, then by default only the link to leave comment will be shown and by clicking on which the comment form will be shown.');

DEFINE('_JCOMMENTS_AP_USE_MAMBOTS', 'Load mambots');
DEFINE('_JCOMMENTS_AP_USE_MAMBOTS_NOTE', 'Enable usage of mambots in comments form (for example to show avatars, etc).');

DEFINE('_JCOMMENTS_A_MESSAGES_LOCKED', 'The form is locked');
DEFINE('_JCOMMENTS_A_MESSAGES_LOCKED_NOTE', 'Please provide the text, which will be shown to the visitor if for the specific item the comments form is locked (tag {jcomments lock} is found in the text of the material).');

DEFINE('_JCOMMENTS_AP_DISPLAY_AUTHOR', 'Người gửi');
DEFINE('_JCOMMENTS_AP_DISPLAY_AUTHOR_NAME', 'Tên thật');
DEFINE('_JCOMMENTS_AP_DISPLAY_AUTHOR_USERNAME', 'Tài khoản (Login)');
DEFINE('_JCOMMENTS_AP_DISPLAY_AUTHOR_NOTE', 'Show username or real name for authorised users. For unauthorised users the name stated in comment form will be shown.');

?>