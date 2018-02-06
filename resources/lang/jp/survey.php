<?php

return [
	//login page
	'signGoogle' => 'アンケート管理システム',
	'error_sign_google' => 'アカウント（Gsuite）でログインしてください。',
	
	//header
	'logout' => 'ログアウト',
	
	//button preview
    'draf' => '下書き',
    'published' => '公開中',
    'closed' => '終了',
    'menu_survey_list' => 'アンケート一覧',
    'menu_survey_download' => 'アンケート一覧',
    'confirm_publish_survey_content' => "このアンケートを公開しますか？",
    'save_publish_survey' => "終了する",
    'cancel_publish_survey' => "キャンセル",
    'confirm_publish_survey_title' => "確認",
    'confirm_button_close' => "終了する",
    'confirm_button_publish' => "公開する",
    'confirm_close_survey_content' => "このアンケートを終了しますか？",
    'confirm_close_survey_title' => "確認",
    'confirm_close_survey_button_close' => "終了する",
    'confirm_close_survey_button_publish' => "Publish",
	'confirm_button_cancel' => "キャンセール",
	
    'survey_list_table_title' => "アンケート一覧",
	'survey_list_table_download_title' => "アンケート一覧",
	'button_create_new_survey'  => 'アンケート作成',
	'survey_create_page_title' => 'アンケート作成',
	'survey_edit_page_title' => 'アンケート編集',
    'survey_list_table_header_column_id' => "Id",
    'survey_list_table_header_column_status' => "ステータス",
    'survey_list_table_header_column_survey_name' => "アンケート名",
    'survey_list_table_header_column_survey_image' => "ヘッダー画像",
    'survey_list_table_header_column_survey_published_at' => "公開日",
    'survey_list_table_header_column_survey_closed_at' => "終了日",
    'survey_list_table_header_column_survey_number_answers' => "回答人数",
	'detail' => 'プレビュー',
	'copy_survey' => 'コピー',
	'edit_survey'  => '編集',
	'go_to_edit' => '編集画面へ',
	'go_to_edit_survey'  => '編集画面へ',
	'button_coppy_url'  => 'URLコピー',
	
    'go_download_button' => 'ダウンロード画面へ',
	'time_created' => '回答日時',
	
    'button_more' => 'もっと',
    'button_less' => '閉じる',
    'answer_download_table' => "アンケート一覧",
    'button_download_csv' => 'CSVダウンロード',
    'button_clear_data' => 'データ削除',
	'confirm_button_clear_data' => '削除する',
	'message_clear_data_not_success' => 'データを削除できませんでした。',
	'message_clear_data_success' => 'データを削除しました。',
    'button_submit' => '内容確定',
    'button_cancel' => 'Cancel',
    'button_preview' => 'プレビュー',
    'confirm_clear_data_title' => '確認',
    'confirm_clear_data_content' => 'このアンケートのデータを削除しますか？',
    
//	create/edit survey screen
	'survey_name_title' => 'アンケート名',
    'survey_name_help_block' => '※ 最大255文字数',
    'survey_thumbnail_title' => 'ヘッダー画像',
    'survey_thumbnail_help_block' => '※ アップロードファイルを指定してください。サイズは5MBまでアップロードが可能です (960 x 300ピクセル)',
    'survey_description_title' => '説明',
    'survey_description_help_block' => '※ アップロードファイルの説明を記載することができます。（5,000文字まで）',
    'survey_header_box_title' => 'ヘッダー設定',
    'survey_content_box_title' => 'アンケート設定',
    'survey_footer_box_title' => 'フッター設定',
    'survey_add_question_button' => '質問を追加する',
    'survey_question_default_text' => '設問分を入力してください',
    'survey_question_help_block_text' => '',
    'question_type_single_text' => '自由回答（短）',
    'question_type_multi_text' => '自由回答（長）',
    'question_type_single_choice' => '選択回答（ラジオ）',
    'question_type_multi_choice' => '選択回答（チェック）',
    'question_type_confirmation' => '利用規約（等）',
    'require_toggle' => '必須',
	'error_input_wrong_create_survey' => 'エラーが発生しました。',
	'error_length_255_characters' => '最大255文字',
	'error_length_5000_characters' => '最大5000文字',
	'error_not_allow_empty' => '必ず入力してください',
	'error_only_allow_file' => '画像のみアップロードしてください',
	'error_limit_5mb' => '最大5MB',
	'error_no_choice' => '選択肢を設定ください',
    'choice_default_text' => '設問分を入力してください ',
    'single_text_placeholder' => '回答者の入力欄',
    'multi_text_placeholder' => '回答者の入力欄',
    'confirmation_help_block' => '',
    'agree_text_placeholder' => '利用規約の内容を入力してください',
    'alert_success_create_survey'  => 'アンケートを設定しました。',
    'alert_fail_create_survey'  => 'アンケード作成が失敗しました。',
	'message_repquire'  => '必ず選択してください',
	'message_confirm_condition' => '規約に承諾してください',
	'error_incorrect_dimension' => '正しい形式で入力して下さい',
	
	
	'column_csv_created_at' => '回答日時',
	'label_choice_survey_draft_status' => '下書き',
	'label_choice_survey_publish_status' => '公開する',
	'label_choice_survey_close_status' => '終了する',
	'radio_label_choice_survey_draft_status' => '下書き',
	'radio_label_choice_survey_publish_status' => '公開する',

    'tooltip_remove_question' => '削除する',
    'tooltip_remove_question_choice' => '選択肢を削除する',
    'tooltip_add_question_choice' => '選択肢を追加する',
	
	//preview page
	'htmlheader_title_preview_draf' => 'プレビュー画面',
	'htmlheader_title_preview_publish' => 'プレビュー画面',
	'htmlheader_title_preview_close' => 'プレビュー画面',
	'message_publish_survey_success' => 'このアンケートを公開しました。',
	'message_publish_survey_not_success' => 'このアンケートを公開できませんでした。',
	'message_close_survey_success' => 'アンケートを終了しました。',
	'message_close_survey_not_success' => 'アンケートを終了できませんでした。',
	'htmlheader_title_preview' => 'プレビュー画面',
	
	//answer survey
	'htmlheader_title_answer_survey' => '問い合わせ',
	'message_255_characters' => '255文字以内で入力してください。',
	'message_5000_characters' => '5000文字以内で入力してください。',
];
