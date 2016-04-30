	$(function() {
			$("#col_one .tableRow").each(function(e) {
				var tableName = $(this).attr('data-table');
				var one = $(this).offset();
				console.log($("#col_two > ."+tableName));
				if($("#col_two > ."+tableName).length > 0) {
					var two = $("#col_two > ."+tableName).offset();
					if(one.top > two.top) {
						$("#col_two > ."+tableName).offset({left:two.left, top:one.top});
					} else {
						$("#col_one > ."+tableName).offset({left:one.left, top:two.top});
					}
				}
			});

			var totalDiff = $(".diff").length;
			
			if(totalDiff > 0) {
				$("#totalDiffs").html("<p><i class='fa fa-exclamation-triangle red'></i> There are "+totalDiff+" discrepancies detected between your two databases.");
			} else {
				$("#totalDiffs").html("<p><i class='fa fa-check green'></i> Your databases seem to be consistent.");
			}

		});