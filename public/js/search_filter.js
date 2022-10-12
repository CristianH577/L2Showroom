var selectsFilterList = document.querySelectorAll("#filter_list select");
var inputs = document.querySelectorAll("#search input[type='text'], input[type='number'], input[type='search']");
const check = document.getElementById("filter_check");
const filters = document.getElementById("filter_list");
var filtersH = filters.getBoundingClientRect().height;
filters.style.height = 0;

window.addEventListener('resize', function () {
  filters.style.height = "unset";
  filtersH = filters.getBoundingClientRect().height;
  filters.style.height = 0;
});

check.onchange = function(e) { 
  if (check.checked) {
    filters.style.cssText = "clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%); height: unset;";
    let start = Date.now();

    let timer = setInterval(function() {
      let timePassed = Date.now() - start;

      filters.style.height = timePassed / 5 + 'px';

      if (timePassed > filtersH*5) clearInterval(timer);

    }, 20);
  }else{
    //filters.style.cssText = "clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); height: 0;";
    let start = Date.now();

    let timer = setInterval(function() {
      let timePassed = Date.now() - start;

      filters.style.height = filtersH - (timePassed / 5) + 'px';

      if (timePassed > filtersH*5) clearInterval(timer);

    }, 20);
  }
};

selectsFilterList.forEach(element => {
  element.onchange = function () {
    element.style.fontWeight = 'unset';
    element.style.color = "var(--fontColor)";
    if (element.value == "") {
      element.style.color = "var(--color3)";
    }else{
      element.style.color = "var(--fontColor)";
    }
  }
});
inputs.forEach(element => {
  element.onkeypress = function () {
    element.style.fontWeight = 'unset';
    element.style.color = "var(--fontColor)";
  }
});

var URLsearch = window.location.search;
if (URLsearch != "") {
  const params = new URLSearchParams(URLsearch);

  if (!!params.get('error')) {
    params.delete('error')
  }
  if (!!params.get('success')) {
    params.delete('success')
  }
  if (!!params.get('actualPage')) {
    params.delete('actualPage')
  }
  
  var e=0;
  for (value of params.values()) {
    if (value != "") {
      e++;
    }
  }

  if (e != 0) {
    filters.style.cssText = "clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%); height: unset;";

    selectsFilterList.forEach(element => {
      var n = element.name;
      var p = params.get(n);
      if (p != "") {
        element.value = p;
        element.style.color = 'var(--colorSelect)';
        element.style.fontWeight = 'bold';
      }
    });
    inputs.forEach(element => {
      var n = element.name;
      var p = params.get(n);
      if (p != "") {
        element.value = p;
        element.style.color = 'var(--colorSelect)';
        element.style.fontWeight = 'bold';
      }
    });
  }
  
}

document.getElementById("resetSearch").onclick = function () {
  resetSearch();
}

function resetSearch() {
  inputs.forEach(element => {
    element.value = "";
    element.style.fontWeight = 'unset';
  });
  document.querySelectorAll("#filter_list select").forEach(element => {
    element.value = "";
    element.style.fontWeight = 'unset';
    element.style.color = "var(--color3)";
  });
}