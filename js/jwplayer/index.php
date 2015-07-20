<script type='text/javascript' src='jwplayer.js'></script>

<div id='mediaplayer'></div>

<script type="text/javascript">
/*
  jwplayer('mediaplayer').setup({
    'flashplayer': 'player.swf',
    'id': 'playerID',
    'width': '480',
    'height': '360',
    'file': 'http://www.youtube.com/watch?v=-KyJUT_RAQc',
    'controlbar': 'bottom',
	'skin' : 'polishedmetal/polishedmetal.xml'
  });
  */
</script>

<script type="text/javascript">
    jwplayer("mediaplayer").setup({
        'flashplayer': 'player.swf',
        'id': 'playerID',
        'width': '480',
        'height': '360',
        'controlbar': 'bottom',
	    'skin' : 'polishedmetal/polishedmetal.xml',
        'playlist': [{
            'file': 'http://www.youtube.com/watch?v=-KyJUT_RAQc',
            'image': '/thumbs/video1.jpg',
            'title': 'daviemen'
        },{
            'file': '/videos/video2.mp4',
            'image': '/thumbs/video2.jpg',
            'title': 'Thuong hieu viet'
        }],
        repeat: 'list'
    });
</script>

