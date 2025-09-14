import { defineStore } from "pinia";




export const useAllNoteStore = defineStore('all-note-store', {
    state: () => ({
        projectId: 0,
        referents: [{
            id: 0,
            title: '',
            indicators: [{
                id: 0,
                name: ''
            }]
        }],
        notes: [{
            id: 0,
            name: '',
            notesByReferent: []
        }]
    })
});
