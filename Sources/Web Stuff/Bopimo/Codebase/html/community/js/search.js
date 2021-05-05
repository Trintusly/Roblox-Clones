$(document).ready(function(){
  $("#searchForm").submit(function(event) {
    event.preventDefault();
    string = $("#searchQuery").val();
    string = string.replace(/\s+/g, '-')
    window.location = "/community/search/"+string+"/1";
  });
});
