$dynamicReport = new Vue({
  el: '#toDoList',
  data: {
    list: json_baseDate,
    // dragList: deepCopy(json_baseDate)
  },
  methods: {

    tab: function (i) {
      var $list = json_baseDate;
      console.log(i, $list);
      $list.forEach(function (item) {
        item.page = false;
      });
      $list[i].page = true;

    }
  }
});

$(function () {
  var $baseCt = $('.baseContent'),
    $page = $baseCt.find('.page');

  $page.each(function (i, v) {
    var $list = $(this).find('.list'),
      $li = $list.find('li');
    $li.each(function () {
      var $tool = $(this).find('.tool'),
        $edit = $tool.find('.edit'),
        $text = $tool.find('.editCt'),
        $delete = $tool.find('.delete');
        // $delete.click(function (e) {
        //   e.preventDefault();
        // })
        $edit.click(function (e) {
          e.preventDefault();
          $text.toggleClass('is-open');
        })
    })
  })
})
