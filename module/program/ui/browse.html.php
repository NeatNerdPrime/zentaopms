<?php
namespace zin;

page
(
    set('title', $title),
    h('h1', 'hello'),
    button('BUTTON'),
    btn('Primary')->primary()->rounded(),
    div
    (
        setClass('primary-pale'),
        h2('Headings2'),
        h3('Headings3'),
        html('<div>test</div>'),
        p('lorem', strong('bold'))
    )
)->x();
