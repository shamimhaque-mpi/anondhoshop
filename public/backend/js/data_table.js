(()=>{
	window.addEventListener('load', ()=>{
		data_table();
	});
	function data_table() {
		// Get All Table Where
		let data_tables = document.querySelectorAll('.data-table');
		if(data_tables) {
			data_tables = Array.isArray(data_tables) ? data_tables : Object.values(data_tables);
			// Get per by per Table
			data_tables.forEach((table, key)=>{
				colspan = table.rows[0].childElementCount;
				appendTr(table, colspan);	
			});
			// Search Key in table data
			table_search(data_tables);
		}
	}

	// Append tr in the table
	function appendTr(table, colspan){
		let tableChildren = table.children;
		tableChildren = Array.isArray(tableChildren) ? tableChildren : Object.values(tableChildren);
		tableChildren.forEach((value)=>{
			if(value.nodeName == "TBODY"){
				value.prepend(SetElement(colspan));	
			}
			else if(value.nodeName == "THEAD"){
				value.prepend(SetElement(colspan));
			}
		});
	}

	// Set Node off Element
	function SetElement(colspan){
		// Create Node
		let tr 		= document.createElement('tr');
		let element = `
			<th colspan="${ colspan }" style="padding: 5px 4px;text-align:left;">
				<input 
					type="text"
					style="padding:5px;width:255px;font-size:15px;outline:none;border:1px solid #ece9e9;" 
					placeholder="Enter keyWord for search..."
					class="data-table-search"
				>
			</th>
		`;
		tr.innerHTML = element;
		return tr;
	}

	// Search Key in table data
	function table_search(data_table) {
		let data_table_search = document.querySelectorAll('.data-table-search');
		data_table_search = Array.isArray(data_table_search) ? data_table_search : Object.values(data_table_search);

		data_table_search.forEach((value, key)=>{
			value.addEventListener('input', ()=>{
				let text = value.value;
				let table = data_table[key];
				// Get All Rows
				let rows = table.rows;
				rows = Array.isArray(rows) ? rows : Object.values(rows);

				rows.forEach((row, rowKey)=>{
					// console.log(rowKey);
					if(rowKey+2 < rows.length){
						// Get text of single row
						let table_text = rows[rowKey+2].innerText;
						// searching text
						text_key = RegExp(text, 'i');

						/*
						 * **************************
						 * Searching key in the 
						 * table text 
						 * ***********************
						*/ 
						if (table_text.search(text_key) > -1 ) {
							if(text != ""){
								rows[rowKey+2].style.display = 'table-row';
							}
							else if (text == "") {
								rows.forEach((s_row, s_rowKey)=>{
									s_row.style.display = "table-row";
								});
							}
						}
						else{
							rows[rowKey+2].style.display = 'none';
						}
					}
				});
			});
		});
	}

})()