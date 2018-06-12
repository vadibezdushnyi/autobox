//** ZEN JS **//
$(document).ready(function() {

   $("#publication-start").datepicker({
      monthNames:["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
      dayNamesMin:["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
      firstDay:1,
      dateFormat:"dd.mm.yy"
   });
   $("#publication-finish").datepicker({
      monthNames:["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
      dayNamesMin:["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
      firstDay:1,
      dateFormat:"dd.mm.yy"
   });

});
