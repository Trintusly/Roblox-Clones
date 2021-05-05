$(function () {
	var response = function (url) {

		if (this.__proto__.constructor !== response) {
			return new response(url);
		}

		this.url = url,
		this.result = false,
		this.get = () => {
			$.get(this.url, (data) => {this.response(data)}).fail( (data)=> {this.response(false)} );
			return this;
		},
		this.post = (postData) => {
			if (postData.hasOwnProperty('token')) {
				if (postData.token == null) {
					postData.token = $("meta[name=token]").attr("content");
				}
			}
			console.log(postData);
			$.post(this.url, postData, (data) => {this.response(data)}).fail( (data)=> {this.response(false)} );
			return this;
		},
		this.onSuccess = (data) => {},
		this.onFail = (data) => {},
		this.success = ( successFunction ) => {
			this.onSuccess = successFunction;
			return this;
		},
		this.fail = ( failFunction ) => {
			this.onFail = failFunction;
			return this;
		},
		this.response = ( data ) => {
			if (data) {
				if (data.status == "ok") {
					this.onSuccess(data);
				} else {
					if (data.hasOwnProperty('error')) {
						this.onFail(data.error);
					} else {
						this.onFail("Unknown");
					}
				}
			} else {
				this.onFail("Unknown");
			}
			return this;
		},
		this.getResult = () => {
			return this;
		}

	}
	window.response = response;
})
