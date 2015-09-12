function ajaxNewData(settings, url){
	doingAjax = true;
	if(settings.currentCount < settings.tableTotal || settings.tableTotal == 0){
		$.post(url, settings, function(data){
			data = JSON.parse(data);
			//console.log(data);
			getNewData(data)
			settings.offset += 100;
			//console.log(settings.offset);
			settings.currentCount = $('#searchResults table tr').length - 2;
			doingAjax = false;
			$(document).trigger('ajax');
		});
	}
}
function getNewData(data) {
	if($('#searchResults table td').length == 0){
		var keys = Object.keys(data[0]);
		var html = '<tr>';
		var option = '<option value="">Search By</option>';
		for(var i = 0; i < keys.length; i++){
			html += '<td>'+keys[i]+'</td>';
			option += '<option value="'+keys[i]+'">'+keys[i]+'</option>';
		}
		html += '</tr>';
		$('#searchResults table').append(html);
		$('#searchBy').append(option);
	}
	
	
	html = '';
	for(var i = 0; i < data.length; i++) {
		if(i != data.length -1){
			html += '<tr>';
			var dataKey = Object.keys(data[i]);
			
			for(var a = 0; a < dataKey.length; a++) {
				html += '<td class="'+dataKey[a]+'">'+data[i][dataKey[a]]+'</td>';
			}
			html += '</tr>';
		}
	}
	$('#searchResults table').append(html);
	tableTotal = data[data.length-1]['num_rows'];
}

function jobsTemplate(data) {
	var keys = Object.keys(data);
	var html = '<div id="job">';
	for(var i = 0; i < keys.length; i++) {
		var title = keys[i].replace('_',' ');
		title =  title.charAt(0).toUpperCase() + title.slice(1);
		html += '<div class="row '+keys[i]+'"><div class="title">'+title+'</div>';
		var classKeys = Object.keys(data[keys[i]][0]);
		for(var n = 0; n < classKeys.length; n++ ) {
			html += '<div class="column medium-6 '+classKeys[n]+'">'+classKeys[n].charAt(0).toUpperCase() + classKeys[n].slice(1).replace('_',' ')+': '+data[keys[i]][0][classKeys[n]]+'</div>';
		}
		html += '</div>';
	}
	html += '</div>';
	return html;
}