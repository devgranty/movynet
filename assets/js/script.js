$('document').ready(function(){
	$('#searchBtn').click(function(){
		$('#searchBarDrawer').slideToggle('fast');
	});

	$('#reportBtn').click(function(){
		$('#reportFormContainer').slideDown('fast');
	});

	$('#closeReportModal').click(function(){
		$('#reportFormContainer').slideUp('fast');
	});

	$('#closeFeedbackModal').click(function(){
		$('#feedbackContainer').slideUp('fast');
	});
});

function loadPageContent(pageNum, pagePath, sortBy){
	$('#loadMoreBtn').text('Loading...');
	$.post(pagePath, {page:pageNum, sortType:sortBy}, function(data){
	    $('#loadMoreBtn').text('Load more');
	    if(data.trim().length == 0){
	        $('#loadMoreBtn').text('No more data').prop('disabled', true).css('cursor', 'default');
	    }
	    $('.page-content').append(data);
	});
}

if('serviceWorker' in navigator){
	window.addEventListener('load', function(){
		navigator.serviceWorker.register('./sw.js').then(function(registration){
		});
	});
}
