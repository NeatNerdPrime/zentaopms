<?php
namespace zin;

set::zui(true);
set::className('page-app');
jsVar('window.defaultAppUrl', $defaultUrl);

if(commonModel::isTutorialMode())
{
    to::head
    (
        h::css(<<<'CSS'
        .shl-tutorial { position: relative!important; z-index: 1010!important; -webkit-box-shadow: 0 0 0 0 #000!important; box-shadow: 0 0 0 0 #000!important; -webkit-transition: -webkit-box-shadow 1s!important; -o-transition: box-shadow 1s!important; transition: -webkit-box-shadow 1s!important; transition: box-shadow 1s!important; transition: box-shadow 1s,-webkit-box-shadow 1s!important }
        .hl-tutorial.hl-in { -webkit-box-shadow: 0 0 20px 0 #ffff8d,0 0 0 2px #ffd180,0 0 0 3000px rgba(0,0,0,.2)!important; box-shadow: 0 0 20px 0 #ffff8d,0 0 0 2px #ffd180,0 0 0 3000px rgba(0,0,0,.2)!important }
        .btn.tooltip-tutorial,.hl-tutorial.hl-in:hover { position: relative!important; z-index: 1010!important; -webkit-box-shadow: 0 0 30px 0 #ffff8d,0 0 0 5px #ffd180,0 0 0 3000px rgba(0,0,0,.3)!important; box-shadow: 0 0 30px 0 #ffff8d,0 0 0 5px #ffd180,0 0 0 3000px rgba(0,0,0,.3)!important }
        CSS)
    );
}

render('pagebase');
