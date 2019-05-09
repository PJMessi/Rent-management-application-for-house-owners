export default class Gate {
    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.role === 'Admin';
    }

    isRenter() {
        return this.user.role === 'Renter';
    }
}