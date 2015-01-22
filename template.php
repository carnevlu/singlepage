<header class="hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <a href="//www.unifr.ch">
                    <img src="//www.reslash.ch/it/img/c.png" id="logosvg"/>
                </a>
            </div>
            <div class="col-sm-6 info-sup">
                <p class="text-right text-uppercase text-nowrap" id="title" contenteditable="true"><?php echo $html['title']; ?></p>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-sm-2 "><ul class="nav nav-pills nav-stacked menu">content</ul></div>
        <div class="col-sm-9 col-sm-offset-1 " id="content" contenteditable="true"><?php echo $html['content']; ?></div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3" id="col1" contenteditable="true"><?php echo $html['col1']; ?></div>
            <div class="col-sm-5" id="col2" contenteditable="true"><?php echo $html['col2']; ?></div>
            <div class="col-sm-3" id="col3" contenteditable="true"><?php echo $html['col3']; ?></div>
        </div>
    </div>
</footer>