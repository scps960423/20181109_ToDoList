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
