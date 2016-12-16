<?php 
if ( ! defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}//end if

class SkinAcme extends SkinTemplate {
	/** Using Bootstrap */
	public $skinname = 'acme';
	public $stylename = 'acme';
	public $template = 'AcmeTemplate';
	public $useHeadElement = true;

	/**
	 * initialize the page
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$out->addModuleScripts( 'skins.acme' );
		
		$out->addMeta( 'viewport', 'user-scalable=yes,initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0' );
//		seo관련
		$out->addMeta( 'description', '오사위키는 유머와 재미를 추구하는 차세대 유머위키 입니다.' );
		$out->addMeta( 'keywords', '오사위키,osawiki,OsaWiki,위키,wiki,' . $this->getSkin()->getTitle() );
//		크롬, 파이어폭스 OS, 오페라
		$out->addMeta('theme-color', '#ffb00e');
//		윈도우 폰
		$out->addMeta('msapplication-navbutton-color', '#ffb00e');
//		트위터 카드
		$out->addMeta('twitter:card', 'summary');
		$out->addMeta('twitter:site', '@osawiki');
		$out->addMeta('twitter:title', $this->getSkin()->getTitle() );
		$out->addMeta('twitter:description', $out->mBodytext );
		$out->addMeta('twitter:image', '//www.osawiki.com/w/skins/acme/img/twit.png');
	}//end initPage

	/**
	 * prepares the skin's CSS
	 */
	public function setupSkinUserCss( OutputPage $out ) {
		global $wgSiteCSS;

		parent::setupSkinUserCss( $out );

		$out->addModuleStyles( 'skins.acme' );
		
		$out->addStyle( 'acme/font-awesome/css/font-awesome.min.css' );

	}//end setupSkinUserCss
}

class AcmeTemplate extends BaseTemplate {
	
	public $skin;

	public function execute() {
		global $wgRequest, $wgUser, $wgSitename, $wgSitenameshort, $wgCopyrightLink, $wgCopyright, $wgBootstrap, $wgArticlePath, $wgGoogleAnalyticsID, $wgSiteCSS;
		global $wgEnableUploads;
		global $wgLogo;
		global $wgTOCLocation;
		global $wgNavBarClasses;
		global $wgSubnavBarClasses;

		$this->skin = $this->data['skin'];
		$_TITLE = $this->getSkin()->getRelevantTitle();
		$action = $wgRequest->getText( 'action' );
		$url_prefix = str_replace( '$1', '', $wgArticlePath );
		$revid = $this->getSkin()->getRequest()->getText( 'oldid' );
		$_URITITLE = rawurlencode($_TITLE);

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();
		$this->html('headelement');
		?>
		<!--header start-->
		<header class="head-section">
		<div class="navbar navbar-default navbar-static-top container">
			<div class="navbar-header">
				<button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button"><span class="icon-bar"></span> <span class="icon-bar"></span>
				<span class="icon-bar"></span></button> <a class="navbar-brand" href="<?php echo $this->data['nav_urls']['mainpage']['href']; ?>"><img src='https://www.osawiki.com/w/images/c/c9/Logo.png' width='200px'></a>
			</div>

			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
				<li id="right-search">
					<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform" role="search">
						<input style="    display: inline-block;" class="form-control search" type="search" name="search" placeholder="Search" title=" Search <?php echo $wgSitename; ?> [ctrl-option-f]" accesskey="f" id="searchInput" autocomplete="off">
						<input type="hidden" name="title" value="특수:검색">
					</form>				
				</li>
				<li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'RecentChanges', null ), '<i class="fa fa-refresh" aria-hidden="true"></i>  <span id="mobile">바뀐 문서<span>'); ?></li>
				<li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Random', null ), '<i class="fa fa-random" aria-hidden="true"></i> <span id="mobile">랜덤</span>'); ?></li>
				<li><a href = "https://bbs.osawiki.com/notice"><i class="fa fa-check" aria-hidden="true"></i> 공지사항</a></li>
				<?php $theMsg = 'toolbox';
				$theData = array_reverse($this->getToolbox()); ?>
				<li class="dropdown">
                   <a class="dropdown-toggle" data-close-others="false" data-delay="0" data-hover="dropdown" data-toggle="dropdown" href="#"><i class="fa fa-wrench" aria-hidden="true"></i> 도구 <i class="fa fa-angle-down"></i></a>
                      <ul aria-labelledby="<?php echo $this->msg($theMsg); ?>" role="menu" class="dropdown-menu" <?php $this->html( 'userlangattributes' ); ?>>
						<?php
							foreach( $theData as $key => $item ) {
								if (preg_match('/specialpages|whatlinkshere/', $key)) {
									continue;
								}
								echo $this->makeListItem( $key, $item );
							}
						?>
						<li id="t-re"><?php echo '<a href="/w/index.php?title=%ED%8A%B9%EC%88%98:%EA%B0%80%EB%A6%AC%ED%82%A4%EB%8A%94%EB%AC%B8%EC%84%9C/'.$_URITITLE.'">';?>역링크</a></li>
						<li id="t-bell"><a href="<?php echo $url_prefix; ?>%ED%8A%B9%EC%88%98:%ED%95%84%EC%9A%94%ED%95%9C%EB%AC%B8%EC%84%9C"></i>작성이 필요한 문서</a></li>
						<li id="t-sharticle"><a href="<?php echo $url_prefix; ?>%ED%8A%B9%EC%88%98:%EC%A7%A7%EC%9D%80%EB%AC%B8%EC%84%9C"></i>짧은 문서</a></li>
						<li id="t-frown"><a href="<?php echo $url_prefix; ?>%ED%8A%B9%EC%88%98:%EC%99%B8%ED%86%A8%EC%9D%B4%EB%AC%B8%EC%84%9C">외톨이(고립된) 문서</a></li>						
						<li id="t-Special"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( '특수문서', null ), '특수 문서', array( 'title' => '특수 문서' ) ); ?></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-close-others="false" data-delay="0" data-hover="dropdown" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-external-link" aria-hidden="true"></i>  <span id="mobile">퀵링크</span> <i class="fa fa-angle-down"></i>
					</a>
                      <ul aria-labelledby="<?php echo $this->msg($theMsg); ?>" role="menu" class="dropdown-menu" <?php $this->html( 'userlangattributes' ); ?>>
<li id="t-bbs"><?php echo '<a href="https://bbs.osawiki.com">';?><i class="fa fa-comments" aria-hidden="true"></i> 오사위키 게시판</a></li>
<li id="t-status"><?php echo '<a href="http://status.osawiki.com">';?><i class="fa fa-tachometer" aria-hidden="true"></i> 서버 상태</a></li>
<li id="t-facebook"><?php echo '<a target="_blank" href="https://www.facebook.com/%EC%98%A4%EC%82%AC%EC%9C%84%ED%82%A4-270530999969921">';?><i class="fa fa-facebook-official" aria-hidden="true"></i> 공식 페이스북</a></li>
<li id="t-twitter"><?php echo '<a target="_blank" href="https://twitter.com/osawiki">';?><i class="fa fa-twitter" aria-hidden="true"></i> 공식 트위터</a></li>
						</ul>
				</li>
				
				<?php if ($wgUser->isLoggedIn()) {
					
				function loginBox() {
					global $wgUser, $wgRequest;
				}
							$email = trim($wgUser->getEmail());
							$email = strtolower($email);
							$email = md5($email) . "?d=identicon";
				?>
				
				<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle" type="button" id="login-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo'<img style="width: 32px;" class="profile-img" src="https://secure.gravatar.com/avatar/'.$email.'" /></a>' ; ?></a>
					<ul class="dropdown-menu">
						<li id="pt-mypage"><?php echo Linker::linkKnown( Title::makeTitle( NS_USER, $wgUser->getName() ), '<i class="fa fa-user" aria-hidden="true"></i>  '.$wgUser->getName(), array( 'title' => '사용자 문서를 보여줍니다.' ) ); ?></li>
						<li id="pt-notifications"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Notifications', null ), '<i class="fa fa-bell" aria-hidden="true"></i> 알림', array( 'title' => '나에게 온 알림을 보여줍니다.' ) ); ?></li>
						<li id="pt-preferences"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'preferences', null ), '<i class="fa fa-cog" aria-hidden="true"></i>  환경 설정', array( 'title' => '환경 설정을 불러옵니다.' ) ); ?></li>
						<li id="pt-watchlist"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'watchlist', null ), '<i class="fa fa-bookmark" aria-hidden="true"></i>  주시 문서', array( 'title' => '주시문서를 불러옵니다.') ); ?></li>
						<li id="pt-mycontris"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Contributions', $wgUser->getName() ), '<i class="fa fa-pencil" aria-hidden="true"></i> 기여 문서', array( 'title' => '내 기여 목록을 불러옵니다.' ) ); ?></li>
						<li id="pt-logout"><?php echo '<a href="/w/index.php?title=특수:로그아웃&returnto='.$_URITITLE.'"><i class="fa fa-sign-out" aria-hidden="true"></i>  로그아웃</a>'; ?></li>
					</ul>
				</li>
				
				<?php } else {
				?>
				
				<li id="pt-login">
				<?php echo '<a href="/w/index.php?title=특수:로그인&returnto='.$_URITITLE.'"><i class="fa fa-sign-in" aria-hidden="true"></i>
 <span id="mobile">로그인</span></a>'; ?>
				</li>
				
				<?php } ?>
				
              </ul>
          </div>
      </div>
    </header>
    <!--header end-->
	
	<!--breadcrumbs start-->

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <h1><?php $this->html( 'title' ) ?></h1><?php $this->html( 'subtitle' ) ?></span>
                </div>
                <div class="col-lg-8 col-sm-8">
                    <ol class="breadcrumb pull-right">
					<?php if ( count( $this->data['content_actions']) > 0 ) {
							foreach($this->data['content_actions'] as $pages) {
								echo '<li><a href="'.$pages['href'].'">'.$pages['text'].'</a></li>';
							}
							} ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!--breadcrumbs end-->
	<!--container start-->
    <section id="body">
	
	<div class="container">
	
	<div class="row">
	<div class="col-md-10 col-md-offset-1 mar-b-30">
<?php if ( $this->data['sitenotice'] && $_COOKIE['alertcheck'] != "yes" ) { ?>
                        <div id="sitenotice"><div style="margin-bottom: 10px;">공지<span style="float:right;"><div id="folding_2" style="display:block;">[<a href="javascript:void(0);" onclick="var f=document.getElementById('folding_1');var s=f.style.display=='block';f.style.display=s?'none':'block';this.className=s?'':'opened';var f=document.getElementById('folding_2');var s=f.style.display=='none';f.style.display=s?'block':'none';var f=document.getElementById('folding_3');var s=f.style.display=='block';f.style.display=s?'none':'block';">펼치기</a>]</div><div id="folding_3" style="display:none;">[<a href="javascript:void(0);" onclick="var f=document.getElementById('folding_1');var s=f.style.display=='block';f.style.display=s?'none':'block';this.className=s?'':'opened';var f=document.getElementById('folding_2');var s=f.style.display=='none';f.style.display=s?'block':'none';var f=document.getElementById('folding_3');var s=f.style.display=='block';f.style.display=s?'none':'block';">접기</a>]</div></a></span><div id="folding_1" style="display:none;"><br><?php $this->html( 'sitenotice' ) ?></div></div></div>
<?php } ?>
	<!-- 광고 -->
	<ins id="noadsense" class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9592402831871199" data-ad-slot="7142234264" data-ad-format="auto"></ins><br>
	<!-- 광고 끝 -->
	<?php $this->html( 'bodytext' ); 
if ( $this->data['dataAfterContent'] ): ?>
				<div class="data-after-content">
				<!-- dataAfterContent -->
				<?php $this->html( 'dataAfterContent' ); ?>
				<!-- /dataAfterContent -->
				</div>
	<?php endif; ?>
	<?php if ( $this->data['catlinks'] ) {
	echo '<br>';
	$this->html( 'catlinks' );
	} ?>
	</div>
	</div>
	</div>
	</section>
	<div class="scroll-buttons"><a class="random-link" href="<?php echo $url_prefix; ?>index.php?title=%ED%8A%B9%EC%88%98:%EC%9E%84%EC%9D%98%EB%AC%B8%EC%84%9C"><i class="fa fa-random" aria-hidden="true"></i><span style="display:none">Random</span></a><a class="scroll-button" href="<?php echo $url_prefix.'index.php?title='.$_URITITLE.'&oldid='.$revid.'&action=edit'; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a><a class="scroll-toc" href="#toc"><i class="fa fa-list-alt" aria-hidden="true"></i></a><a class="scroll-button" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a><a class="scroll-bottom" href="#footer"><i class="fa fa-arrow-down" aria-hidden="true"></i></a></div>
	<!--small footer start -->
    <footer class="footer-small" id="footer">
        <div class="container">
            <div class="row">
                  <div class="copyright">
					<p><?php $this->html( 'lastmod' ) ?></p>
                    <p><?php $this->html( 'copyright' ) ?></p>
					<ul class="list-inline pull-left">
						<li><a href = "<?php echo $url_prefix; ?>%EC%98%A4%EC%82%AC%EC%9C%84%ED%82%A4:%EC%9D%B4%EC%9A%A9%EC%95%BD%EA%B4%80">Term of Service</a></li>
						<li><a href = "<?php echo $url_prefix; ?>%EC%98%A4%EC%82%AC%EC%9C%84%ED%82%A4:%EA%B0%9C%EC%9D%B8%EC%A0%95%EB%B3%B4%EC%B7%A8%EA%B8%89%EB%B0%A9%EC%B9%A8">Privacy policy</a></li>
						<li><a href = "<?php echo $url_prefix; ?>%EC%98%A4%EC%82%AC%EC%9C%84%ED%82%A4:%EC%86%8C%EA%B0%9C">오사위키 소개</a></li>
						<li><a href = "<?php echo $url_prefix; ?>%EC%98%A4%EC%82%AC%EC%9C%84%ED%82%A4:%EC%B1%85%EC%9E%84%EC%9D%98_%ED%95%9C%EA%B3%84%EC%99%80_%EB%B2%95%EC%A0%81%EA%B3%A0%EC%A7%80">Disclaimer</a></li>
					</ul>
					<a rel="license" href="//creativecommons.org/licenses/by-sa/4.0/"><img alt="크리에이티브 커먼즈 라이선스" style="border-width:0" class="pull-right" src="//i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a>
					<a href="https://www.mediawiki.org"><img style="margin-right: 10px; " class="pull-right" src="https://www.osawiki.com/w/resources/assets/poweredby_mediawiki_88x31.png" srcset="/w/resources/assets/poweredby_mediawiki_132x47.png 1.5x, /w/resources/assets/poweredby_mediawiki_176x62.png 2x"></a>
					<a href="https://shapebootstrap.net"><img style="margin-right: 10px; margin-top:5px; margin-bottom: 20px;" class="pull-right" src="https://shapebootstrap.net/templates/default/images/presets/preset1/logo.png"></a>
				  </div>
            </div>
        </div>
    </footer>
     <!--small footer end-->
	<?php
		$this->html('bottomscripts');
		$this->html('reporttime');

		if ( $this->data['debug'] ) {
			$this->text( 'debug' );
		}
		?>
	</body>
		</html>
	<?php }
	
} ?>
