$(document).ready(function () {
    $('.open-modal').click(function () {
        console.log($(this).data('character'));
        const character = $(this).data('character')
        const modalId = $(this).data('target');
        $(modalId).html(
            `<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col d-flex">
                                        <img src="${character.image}" alt="${character.name}" class="img-thumbnail">
                                    </div>
                                    <div class="col">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>Attribute</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#</td>
                                                    <td>${character.id}</td>
                                                </tr>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>${character.name}</td>
                                                </tr>
                                                <tr>
                                                    <td>Gender</td>
                                                    <td>${character.gender}</td>
                                                </tr>
                                                <tr>
                                                    <td>Location</td>
                                                    <td>${character.location.name}</td>
                                                </tr>
                                                <tr>
                                                    <td>Origin</td>
                                                    <td>${character.origin.name}</td>
                                                </tr>
                                                <tr>
                                                    <td>Species</td>
                                                    <td>${character.species}</td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>${character.status}</td>
                                                </tr>
                                                <tr>
                                                    <td>Type</td>
                                                    <td>${character.type}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    `
        );
    });
});
