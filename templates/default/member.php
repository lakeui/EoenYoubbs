<?php 
if (!defined('IN_SAESPOT')) exit('error: 403 Access Denied'); 

echo '
<div class="title">
    <i class="fa fa-angle-double-right"></i> 会员：',$m_obj['name'],' 
</div>

<div class="main-box">
<div class="member-avatar"><img src="/avatar/large/',$m_obj['avatar'],'.png" alt="',$m_obj['name'],'" /></div>
<div class="member-detail">
<p>会员：<strong>',$m_obj['name'],'</strong> (第',$m_obj['id'],'号会员，',$m_obj['regtime'],'加入)';
if($cur_user && $cur_user['flag']>=99){
    echo ' &nbsp;&nbsp;&nbsp; • (',$m_obj['flag'],') <a href="/admin-setuser-',$m_obj['id'],'">编辑</a>';
}
echo '
</p>
<p>主贴： ',$m_obj['articles'],'  &nbsp;&nbsp;&nbsp; 回贴： ',$m_obj['replies'],'</p>
<p>网站： <a href="',$m_obj['url'],'" target="_blank" rel="nofollow">',$m_obj['url'],'</a></p>';

if($weibo_user['openid']){
    echo '<p>新浪微博： <a href="http://weibo.com/',$weibo_user['openid'],'" target="_blank" rel="nofollow">http://weibo.com/',$weibo_user['openid'],'</a></p>';
}
if($openid_user['name']){
    echo '<p>腾讯微博： <a href="http://t.qq.com/',$openid_user['name'],'" target="_blank" rel="nofollow">http://t.qq.com/',$openid_user['name'],'</a></p>';
}

echo '</div>';
if($cur_user && $m_obj['id']!=$cur_user['id']){
	echo'<div class="member-floow">
			<a id="btnFollow" href="javascript:;" data-id="'.$m_obj['id'].'" class="fl">关注TA</a>
			 <a href="/newmessage/'.$m_obj['id'].'#newmsg" class="msm">发私信</a>
		</div>';
}
echo'<div class="c"></div>
</div>';


if($m_obj['articles']){
echo '
<div class="title">
   <i class="fa fa-angle-double-right"></i>  ',$m_obj['name'],' 最近发表的帖子
</div>

<div class="main-box home-box-list">';

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar"><a href="/user/',$m_obj['id'],'">';
if($is_spider){
    echo '<img src="/avatar/normal/',$m_obj['avatar'],'.png" alt="',$m_obj['name'],'" />';
}else{
    echo '<img src="/static/grey.gif" data-original="/avatar/normal/',$m_obj['avatar'],'.png" alt="',$m_obj['name'],'" />';
}
echo '    </a></div>
    <div class="item-content">
        <h1><a href="/topics/',$article['id'],'">',$article['title'],'</a></h1>
        <span class="item-date"><i class="fa fa-archive"></i> <a href="/nodes/',$article['cid'],'">',$article['cname'],'</a>&nbsp;&nbsp;<i class="fa fa-user"></i> <a href="/user/',$m_obj['id'],'">',$m_obj['name'],'</a>';
if($article['comments']){
    echo '&nbsp;&nbsp;<i class="fa fa-clock-o"></i> ',$article['edittime'],'&nbsp;&nbsp;<i class="fa fa-user-secret"></i> 最后回复来自 <a href="/user/',$article['ruid'],'">',$article['rauthor'],'</a>';
}else{
    echo '&nbsp;&nbsp;<i class="fa fa-clock-o"></i> ',$article['addtime'];
}
echo '        </span>
    </div>';
if($article['comments']){
    $gotopage = ceil($article['comments']/$options['commentlist_num']);
    if($gotopage == 1){
        $c_page = '';
    }else{
        $c_page = '/'.$gotopage;
    }
    echo '<div class="item-count"><a href="/topics/',$article['id'],$c_page,'#reply',$article['comments'],'">',$article['comments'],'</a></div>';
}
echo '    <div class="c"></div>
</div>';

}

echo '</div>';
}
echo '
<script type="text/javascript">
$(document).ready(function(){
    var target=$("#btnFollow");
    $.ajax({
        type: "GET",
        url: "/follow/user?act=isfo&id="+target.attr("data-id"),
        success: function(msg){
            if(msg == 1){
                target.text("已关注");
            }
       }
    });
    
    target.click(function(){
        if(target.text() == "关注TA"){
            $.ajax({
                type: "GET",
                url: "/follow/user?act=add&id="+target.attr("data-id"),
                success: function(msg){
                    if(msg == 1){
                        target.text("已关注");
                    }
               }
            });
        }else{
            $.ajax({
                type: "GET",
                url: "/follow/user?act=del&id="+target.attr("data-id"),
                success: function(msg){
                    if(msg == 1){
                        target.text("关注TA");
                    }
               }
            });
        }
    });
});
</script>
';

?>
