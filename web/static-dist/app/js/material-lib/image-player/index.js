webpackJsonp(["app/js/material-lib/image-player/index"],[function(a,e){"use strict";var i=$("#image-player");$.get(i.data("url"),function(a){i.html('<img src="'+a.preview+'" style="width: 100%; height:auto; display:block">')})}]);