class Auth {
    constructor() {
        this.userData = JSON.parse(localStorage.getItem('userData'));
    }

    login(token, cb) {
        this.userData = {'authenticated': true, 'token': token};
        localStorage.setItem('userData', JSON.stringify(this.userData));
        cb();
    }

    logout(cb) {
        this.userData = {'authenticated': false, 'token': null};
        localStorage.setItem('userData', JSON.stringify(this.userData));
        cb();
    }

    isAuthenticated() {
        return this.userData.authenticated;
    }

    getToken() {
        return this.userData.token;
    }
}

export default new Auth();
