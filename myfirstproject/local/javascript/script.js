function changeCurrentPage (page) {
	const pageElem = document.getElementById(`${page}`)
	pageElem.classList.add('active')
}
function changePage(argument, property) {
	fetch(`http://myfirstproject/?${property}=${argument}`)
		.then((data) => data.text())
			.then(dataText => {
				const page = document.querySelector('.aroundMainWrapper')
				page.innerHTML = `${dataText}`
	})
}
