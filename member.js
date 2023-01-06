document.getElementById('start-date').valueAsDate = new Date();

document.getElementById('btn-searchRecByDate').addEventListener('click', function() {
    console.log('點擊了按鈕！');
  });

document.getElementById('end-date').addEventListener('input', function() {
    var startDate = document.getElementById('start-date').value;
    var endDate = this.value;
  
    if (startDate && endDate && startDate > endDate) {
      alert('終止日期必須在起始日期之後！');
      this.value = startDate;
    }
  });

  document.getElementById('start-date').addEventListener('focus', function() {
    this.style.backgroundImage = 'url(calendar-active.png)';
  });
  
  document.getElementById('start-date').addEventListener('blur', function() {
    this.style.backgroundImage = 'url(calendar.png)';
  });