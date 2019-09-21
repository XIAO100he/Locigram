	<footer id="footer">
		<div class="footer-left">
			<h5>Locigram</h5>
		</div>
		<div class="footer-right">
			© 2019 locigram.com All Rights Reserved.
		</div>
	</footer>
	
<script src="js/vendor/jquery-2.2.2.min.js"></script>
<script>
	$(function(){
		
//		//footerを最下部に固定 //innerHeight:要素のpaddingを含んだ高さ
//		//.offset()メソッドは、documentを基準とする要素の位置情報を取得
//		//outerHeight:ボーダーの外側の高さを数値で取得
//		var $ftr = $('#footer');
//		if( window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
//			$ftr.attr({'style': 'position:fixed; top:' +(window.innnerHeight - $ftr.outerHeight()) +'px;'});
//		}
//		
//		//メッセージ表示
//		var $jsShowMsg = $('#js-show-msg');
//		var msg = $jsShowMsg.text();
//		if(msg.replace(/^[\s　]+|[\s　]+$/g, "").lenght){
//			$jsShowMsg.slideToggle('slow');
//			setTimeout(function(){$jsShowMsg.slideToggle('slow'); }, 5000);
//		}
//		
		//画像ライブプレビュー
		var $dropArea = $('.area-drop');
		var $fileInput = $('.input-file');
		

		//stopPropagation()は、親要素への伝播をキャンセル
		//preventDefault() は、その要素のイベントをキャンセル
		$dropArea.on('dragover', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).css('border', '3px #aaa dashed');
		});
		
		$dropArea.on('dragleave', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).css('border', 'none');
		});
		
		$fileInput.on('change', function(e){
			$dropArea.css('border', 'none');
			var file = this.files[0],
					//siblings:マッチした各要素の兄弟要素を取得
					$img =$(this).siblings('.prev-img'),
					//fileReader:ファイルを読み込む
					fileReader = new FileReader();
			//5. 読み込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
			//event.targetプロパティは、イベントの委任を実装
			fileReader.onload = function(event){
				$img.attr('src', event.target.result).show();
			};
			// 6. 画像読み込み
			fileReader.readAsDataURL(file);
		});
		
		
	})

</script>
</body>
