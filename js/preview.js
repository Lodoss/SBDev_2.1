var b64s  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='

function ajaxpreview(objname) {
     var ajax = new tbdev_ajax();
     ajax.onShow ('');
     var varsString = "";
     ajax.requestFile = "preview.php?ajax";
     var txt = enBASE64(document.getElementById(objname).value);
     ajax.setVar("msg", txt);
     ajax.method = 'POST';
     ajax.element = 'preview';
     ajax.sendAJAX(varsString);

}

 //  base64_кодирование

	function enBASE64(input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;

		input =_utf8_encode(input);

		while (i < input.length) {

			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output +
			this.b64s.charAt(enc1) + this.b64s.charAt(enc2) +
			this.b64s.charAt(enc3) + this.b64s.charAt(enc4);

		}

		return output;
	}


//utf8_кодирование
function _utf8_encode (string) {
	string = string.replace(/\r\n/g,"\n");
	var utftext = "";

	for (var n = 0; n < string.length; n++) {

	var c = string.charCodeAt(n);

	if (c < 128) {
	utftext += String.fromCharCode(c);
			                            }
			
	else if((c > 127) && (c < 2048)) {
	
	utftext += String.fromCharCode((c >> 6) | 192);
	utftext += String.fromCharCode((c & 63) | 128);
				}
			
	else {
	
	utftext += String.fromCharCode((c >> 12) | 224);
	utftext += String.fromCharCode(((c >> 6) & 63) | 128);
	utftext += String.fromCharCode((c & 63) | 128);
	        }

		}

	return utftext;
	}