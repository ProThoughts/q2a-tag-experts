<?php

class qa_tag_experts_widget {

    function allow_template($template)
    {
        return ($template=='tag');	//only visible on tag pages
    }
    function allow_region($region)
	{
	    return true;				//allowed to be placed anywhere
	}

	function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
	{

		if(!qa_opt("qa_tag_experts_enable")) return;

	    $parts=explode('/', $request);
	    $tag=$parts[1];						//gets the tag

	    if (!$tag) return;

	    $tagid = qa_db_read_one_value(qa_db_query_sub('SELECT wordid FROM ^words WHERE word = # LIMIT 1;', $tag), true);

	    if (!$tagid) return;

	    $topusers = $this->get_top_users($tagid);

	    if (!$topusers) return;

	    $themeobject->output('
			<div class="tag-experts">
            <h4>'.qa_lang_html('tag_experts_lang/title').$tag.' </h4>'.
            '
			<div class="row tagexperts">
			<ul>');

	    for($i = 0; $i < count($topusers); $i++){
				$user = $topusers[$i];
				$themeobject->output('
				<li>');
				$themeobject->output(
					qa_get_user_avatar_html($user['flags'], $user['email'], $user['handle'], $user['avatarblobid'], 30,30,30, true));
				$themeobject->output(
					'<span class="caption">');
				$themeobject->output(
					qa_get_one_user_html($user['handle'], false).'
					<p class="uscore">'.$user['answers'].' ');
				if ($user['answers'] == 1){
					$themeobject->output(qa_lang_html('tag_experts_lang/answer'));
				}
				else{
					$themeobject->output(qa_lang_html('tag_experts_lang/answers'));
				}

				$themeobject->output(' ('.$user['bestanswers'].' '.qa_lang_html('tag_experts_lang/bestanswers').')</span>
					');
			}

				$themeobject->output(
'
				</div>
				</div>');

	}
	function get_top_users($tagid){
		$query = "
			SELECT	^users.userid as userid,
					^users.handle as handle,
			        ^users.avatarblobid as avatarblobid,
			        ^users.avatarwidth as width,
			        ^users.avatarheight as height,
			        ^users.flags as flags,
			        ^users.email as email,
			        a.score as score,
			        a.Best_Answers as bestanswers,
			     	a.Answers as answers
			FROM	(
			    SELECT	^posts.userid,
			            SUM(CASE
			                WHEN q.postid IS NULL THEN 1
			                ELSE 2
			            END) AS Score,
			            COUNT(q.postid) AS Best_Answers,
			            COUNT(*) AS Answers
			    FROM	^posts
			    INNER JOIN(
			            SELECT	postid
			            FROM	^posttags
			            WHERE 	wordid= # 
			        ) tag ON ^posts.parentid = tag.postid
			    LEFT JOIN ^posts q ON tag.postid = q.postid AND q.selchildid = ^posts.postid
			    GROUP BY userid
			    LIMIT 5
			) a
			JOIN 	^users ON a.userid = ^users.userid
			ORDER BY Score DESC
		";
		$result = qa_db_query_sub($query, $tagid);
		$users = qa_db_read_all_assoc($result);
		return $users;
	}
}