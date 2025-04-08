async function getData(id, url) {
    let fullUrl = `${url}/${id}`;
    const response = await fetch(fullUrl);
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return await response.json()
}

$(document).ready(function () {
    $('#select1').change(async function () {
        const courseId = $(this).val();
        const fetchUrl = $(this).data('fetch');
        const targetSelect = $(this).data('target');

        if (!courseId) {
            $(`#${targetSelect}`).html('<option value="">Select a subject</option>');
            return;
        }

        try {
            const response = await fetch(`${fetchUrl}?courseId=${courseId}`);
            if (!response.ok) {
                throw new Error('Failed to fetch subjects');
            }

            const result = await response.json();

            if (result.status && Array.isArray(result.data)) {
                let subjectOptions = '<option value="">Select a Subject</option>';
                result.data.forEach(subject => {
                    subjectOptions += `<option value="${subject.id}">${subject.name}</option>`;
                });

                $(`#${targetSelect}`).html(subjectOptions);
            } else {
                $(`#${targetSelect}`).html('<option value="">No subjects available</option>');
            }
        } catch (error) {
            console.error('Error:', error);
            $(`#${targetSelect}`).html('<option value="">Error loading subjects</option>');
        }
    });
});