$(document).ready(function() {
    //add new section to survay
    $("body").on("click", ".addRecommendation", function() {
        $sectionsDiv = $(this)
            .closest(".addSectionOption")
            .siblings("#SectionsDiv");
        $newSection = $("#SectionTemp")
            .clone()
            .removeClass("display_none")
            .attr("id", "");
        $($sectionsDiv).removeClass("display_none");
        $($sectionsDiv).append($newSection);
        $(".addSectionOption").removeClass('error');
    });

    let recommendation_ids = [];
    $("body").on("click", ".removeRecommendation", function() {
        var sectionDiv = $(this).closest(".sectionDiv");
        recommendation_ids.push($(this).closest(".sectionDiv").find("input[name='id']").val());
        console.log(recommendation_ids);
        var sectionsDiv = $(sectionDiv).parents("#SectionsDiv");
        $(sectionDiv)
            .closest(".sectionDiv")
            .slideUp(500, function() {
                $(sectionDiv).remove();
                if ($(sectionsDiv).find(".sectionDiv").length == 0) {
                    $(sectionsDiv).addClass("display_none");
                }
            });
    });

    //submit survey form
    $("body").on("submit", "#recommendedrlsForm", function(event) {
        event.preventDefault();
        $form = $(this);
        $submit = $("#submit");
        $($submit).prop("disabled", true);
        $sections = $($form).find("#SectionsDiv").find(".sectionDiv"); //get survey sections
        let section_error = false;
        let validated_sections = [];
        if ($sections.length == 0) {
            $($submit).prop("disabled", false);
            return false;
        }
        $.each($sections, function(key, section) {
            var create_or_update = $('input[name="CreateOrUpdate"]').val();
            let validated_section = recommendedUrlsSectionValidation(section, create_or_update);

            if (!validated_section) {
                section_error = true;
                return false;
            }
            validated_sections.push(validated_section);
        });
        if (!section_error) {
            let rangeRecommendations = {
                sections: validated_sections,
                _token: $('input[name="_token"]').val(),
            };
            console.log(rangeRecommendations);
            $.ajax({
                    type: $('input[name="_method"]').val(),
                    url: $form.attr("action"),
                    data: rangeRecommendations,
                })
                .done(function(data) {
                    if (data["error_status"]) {
                        displayErrors(data["errors"]);
                        $($submit).prop("disabled", false);
                    } else {
                        uploadUrlRecommendationImage(recommendation_ids);
                        $($submit).prop("disabled", false);
                        swal({
                            title: "Saved sccessfully",
                            type: "success",
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        }, function() {
                            setTimeout(function() {
                                location.reload();
                            }, 10);
                        });
                    }
                })
                .fail(function(data) {
                    $($submit).prop("disabled", false);
                });
        } else {
            $($submit).prop("disabled", false);
        }
    });

    function displayErrors($serverErrors) {
        var $errorsContianer = $(".alert-danger").find("ul");
        $($errorsContianer).empty();
        $.each($serverErrors, function($key, $errors) {
            $.each($errors, function($key, $error) {
                $($errorsContianer).append("<li>" + $error + "</li>");
            });
        });
        $($errorsContianer)
            .parents(".alert-danger")
            .removeClass("display_none");
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    function uploadUrlRecommendationImage() {
        var form = $("#recommendedrlsForm")[0];
        var form_data = new FormData(form);
        var risk_range_id = $('input[name="riskRange_id"]').val();
        var create_or_update = $('input[name="CreateOrUpdate"]').val();
        form_data.append("risk_range_id", risk_range_id);
        form_data.append("create_or_update", create_or_update);
        form_data.append("recommendation_ids", recommendation_ids);
        $.ajax({
            url: $("#upload").val(),
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(data) {
                // window.location.replace($("#browse").val());
            },
            error: function() {
                // window.location.replace($("#browse").val());
            },
        });
    }

    function recommendedUrlsSectionValidation(section, create_or_update) {
        let validated = false;
        let title_ar = $(section).find("input[name='title_ar']");
        let title_en = $(section).find("input[name='title_en']");
        let link_text_ar = $(section).find("input[name='link_text_ar']");
        let link_text_en = $(section).find("input[name='link_text_en']");
        let link = $(section).find("input[name='link']");
        let description_ar = $(section).find("textarea[name='desc_ar']");
        let description_en = $(section).find("textarea[name='desc_en']");
        let image = $(section).find("input[name='image[]']")[0];
        let id = $(section).find("input[name='id']");
        if (
            title_ar.val() != "" &&
            // title_en.val() != "" &&
            description_ar.val() != "" &&
            // description_en.val() != "" &&
            link_text_ar.val() != "" &&
            // link_text_en.val() != "" &&
            link.val() != "" &&
            (create_or_update == 'Update' || (create_or_update == 'Create' && image.files[0] != undefined))
        ) {
            hideErrors(section);
            validated = {
                title: { ar: title_ar.val(), en: title_en.val() },
                description: { ar: description_ar.val(), en: description_en.val() },
                link_text: { ar: link_text_ar.val(), en: link_text_en.val() },
                link: link.val(),
                id: id.val()
            };
        } else {
            if (!(title_ar.val() != "")) {
                showError(section, title_ar, "ar");
            }
            // if (!(title_en.val() != "")) {
            //     showError(section, title_en, "en");
            // }
            if (!(description_ar.val() != "")) {
                showError(section, description_ar, "ar");
            }
            // if (!(description_en.val() != "")) {
            //     showError(section, description_en, "en");
            // }
            if (!(link_text_ar.val() != "")) {
                showError(section, link_text_ar, "ar");
            }
            // if (!(link_text_en.val() != "")) {
            //     showError(section, link_text_en, "en");
            // }
            if (image.files[0] == undefined) {
                showError(section, image);
            }
        }

        return validated;
    }

    function showError(parent_div, input, lang = null, errorMessage = null) {
        $(parent_div).addClass("error");
        $(input).addClass("error");
        if (lang) {
            $(`.change_lang[lang=${lang}`).click();
        }

        if (errorMessage) {
            $(input).siblings('.error_message').remove();
            $('<p/>', {
                "class": 'error_message',
                "text": errorMessage
            }).insertAfter($(input));
            $(input)
        }

        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    function hideErrors(parent_div) {
        $(parent_div).removeClass("error");
        $(parent_div).find(".error").removeClass("error");
    }
});