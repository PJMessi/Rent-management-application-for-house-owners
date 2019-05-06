export default class Gate {
    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.role === 'admin';
    }

    isRenter() {
        return this.user.role === 'renter';
    }
}