<header>
    <nav class="navbar navbar-default">
        <div class="container-flud">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
    				<span class="sr-only">Toggle navigation</span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    			</button>
                <a class="navbar-brand" href="./">
                    ライセンス管理ツール
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav navbar-right">
                    <?php if(!empty($_SESSION['administratorId'])) { ?>
    				<li><a href="./logout.php"><span class="glyphicon glyphicon-log-out logout-icon" aria-hidden="true"></span>ログアウト</a></li>
                    <?php } ?>
    			</ul>
            </div>
        </div>
    </nav>
</header>
