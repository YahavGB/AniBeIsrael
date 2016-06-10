var IBIApp =
{
	userData: null,
	baseUrl: '',
	initWelcomePage: function() {
		$("#profile-picture-filter-button").click(function() {
			if (typeof(IBIApp.userData.id) === "undefined") {
				BootstrapDialog.show({
					type: BootstrapDialog.TYPE_INFO,
		            title: 'שים לב',
		            message: 'אינך יכול לבצע פעולה זו כיוון שאינך מחובר באמצעות Facebook.<br />אנא התחבר עם חשבון הFacebook שלך כדי להתחיל בהליך.',
		            buttons: [{
		                label: 'סגור',
		                action: function(dialogItself){
		                    dialogItself.close();
		                }
		            }]
		        });
		        
				return;
			}
			IBIApp.createFilteredPicture();
		});
	},
	
	createFilteredPicture: function() {
		/* Disable the buttons and show the loading overlay */
		$("#profile-picture-filter-button").addClass('hide');
		$(".profile-picture .loading-anim").removeClass('hide');
		$(".profile-picture .overlay").removeClass('hide');
		
		/* Create the picture */
		$.get(IBIApp.baseUrl + '/image-filter/create', function (responseText) {
			var data = JSON.parse(responseText);
			if (!data.success) {
				BootstrapDialog.show({
					type: BootstrapDialog.TYPE_DANGER,
					title: 'שגיאה ארעה',
					message: 'לא היה ניתן להפעיל את הפילטר על תמונת הפרופיל שלך. אנא נסה לרענן את העמוד, להתחבר לפייסבוק ולהפעיל את הפילטר מחדש.<br />אם הצעה זו לא פותרת את הבעיה, אנא צור קשר עם צוות הקמפיין.',
					buttons: [
					{
		                label: 'רענן עמוד זה',
		                action: function(dialogItself){
		                    window.location.reload();
		                }
		            },
		            {
		                label: 'סגור',
		                action: function(dialogItself){
		                    dialogItself.close();
		                }
		            }]
				});
				return;
			}
			
			/* Re-show the thumbnail */
			$(".profile-picture .loading-anim").addClass('hide');
			$(".profile-picture .overlay").addClass('hide');
			$("#profile-picture-filter-done-button").removeClass('hide');
			
			/* Set the image as a thumbnail */
			$(".profile-picture").css('background-image', 'url(' + data.path + ')');
			
			/* Setup the "show" button */
			$("#profile-picture-filter-done-button").click(function() {
				var message = "תמונת הפרופיל שלך מוכנה. כעת תוכל לשתף אותה עם חבריך ולהעלות אותה לפרופיל האישי שלך.";
				message += "<br />להלן תצוגה מלאה של תמונת הפרופיל שלך:<br />";
				message += "<img src=\"" + data.path + "\" alt=\"תמונת הפרופיל לאחר הוספת דגל ישראל\" />";
				
				var dialog = BootstrapDialog.show({
					type: BootstrapDialog.TYPE_SUCCESS,
					title: 'תמונת הפרופיל שלך מוכנה',
					message: message,
					cssClass: 'profile-picture-dialog',
					buttons: [
					{
		                label: 'סגור',
		                action: function(dialogItself){
		                    dialogItself.close();
		                }
		            }]
				});

			});
		});
	}
};