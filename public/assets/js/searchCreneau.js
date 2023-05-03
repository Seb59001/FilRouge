document.querySelector('#search').addEventListener('keyup', function () {
  const value = this.value.toLowerCase();
  const rows = document.querySelectorAll('table tbody tr');
  rows.forEach(row => {
    let found = false;
    const cells = row.querySelectorAll('td');
    cells.forEach(cell => {
      if(cell.textContent.toLowerCase().includes(value)){
        found = true;
      }
    });
    if(found){
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});