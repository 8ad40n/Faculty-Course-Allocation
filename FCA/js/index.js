$('#search_field').on('keyup', function() {
    var value = $(this).val();
    var patt = new RegExp(value, "i");
  
    $('#myTable').find('tr').each(function() {
      if (!($(this).find('td').text().search(patt) >= 0)) {
        $(this).not('.myHead').hide();
      }
      if (($(this).find('td').text().search(patt) >= 0)) {
        $(this).show();
      }
  
    });
  
   
  });