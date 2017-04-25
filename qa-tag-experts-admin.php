<?php
class qa_tag_experts_admin {

	function option_default($option) {

		switch($option) {
			case 'qa_tag_experts_enable': 
				return 1;
			case 'qa_tag_experts_css': 
				$css = '.tagexperts li {
        display: inline-block;
    	height: 55px;
}

.tagexperts .caption {
    display: inline-block;
    margin: 0 20px 0 5px;
    vertical-align: middle;
    line-height: 1;
    font-size: 10pt;
}

.tag-experts h4 {
    margin: 0 0 10px 20px;
}

.tagexperts{
	overflow: hidden;
    width: 105%;
    height: 50px;
}
.tagexperts ul{
	margin-left: -10px;
}
.tagexperts img{
	max-height: 100%;
	width: auto;
}';
				return $css;
			default:
				return null;				
		}

	}
	
	function allow_template($template)
	{
		return ($template!='admin');
	}       

	function admin_form(&$qa_content)
	{                       

		// Process form input

		$ok = null;

		if (qa_clicked('qa_tag_experts_save')) {
			qa_opt('qa_tag_experts_enable',(bool)qa_post_text('qa_tag_experts_enable'));
			qa_opt('qa_tag_experts_css',(string)qa_post_text('qa_tag_experts_css'));
			$ok = qa_lang('admin/options_saved');
		}
		
		// Create the form for display

		$fields = array();
		$fields[] = array(
				'label' => 'Enable Tag Experts',
				'tags' => 'name="qa_tag_experts_enable"',
				'value' => qa_opt('qa_tag_experts_enable'),
				'type' => 'checkbox',
				);
		$fields[] = array(
				'label' => 'Tag Experts CSS',
				'tags' => 'name="qa_tag_experts_css"',
				'value' => qa_opt('qa_tag_experts_css'),
				'type' => 'textarea',
				'rows' => 50,
				);

		return array(           
				'ok' => ($ok && !isset($error)) ? $ok : null,

				'fields' => $fields,

				'buttons' => array(
					array(
						'label' => qa_lang_html('main/save_button'),
						'tags' => 'NAME="qa_tag_experts_save"',
					     ),
					),

			    );
	}
}

