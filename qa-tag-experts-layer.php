<?php
class qa_html_theme_layer extends qa_html_theme_base {
	function head_css(){
		$version=1.0;
		$template = $this->template;
		if((qa_opt('qa_tag_experts_enable')  == 1) &&  ($template === 'tag')
		  ){
			$this->output('<style type="text/css">
					'.qa_opt('qa_tag_experts_css').'
					</style>
					');
		}
		qa_html_theme_base::head_css();
		
	}

}

