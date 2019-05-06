<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="$gate.isAdmin()">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
            <div class="col-md-12" v-else>
                <not-found></not-found>
            </div>
        </div>
    </div>
</template>
