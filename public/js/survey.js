$(document).ready(function() {
    //change language

    $("body").on("click", ".change_lang", function() {
        $lable = $(this);

        $($lable).addClass("active");
        $old_lable = $($lable).siblings("label")[0];
        $($old_lable).removeClass("active");

        $lang = $(this).attr("lang");
        $oldLang = $($old_lable).attr("lang");

        $(`.${$lang}`).removeClass("display_none");

        $(`.${$oldLang}`).addClass("display_none");

        $(".lang").html($lang);
    });

    $('body').on('focus', 'input', function() {
        $(this).removeClass('error');
        // $(this).siblings('.error_message').remove();
    });

    $('body').on('focus', 'textarea', function() {
        $(this).removeClass('error');
        // $(this).siblings('.error_message').remove();
    });


    //add new section to survay
    $("body").on("click", ".addSection", function() {
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

    //add new section to survay
    $("body").on("click", ".addGeneralAdvice", function() {
        $generalAdvicesDiv = $(this)
            .closest(".addGeneralAdviceOption")
            .siblings("#GeneralAdvicesDiv");
        $newAdvice = $("#AdviceTemp")
            .clone()
            .removeClass("display_none")
            .addClass("pb-3")
            .attr("id", "");
        $($generalAdvicesDiv).removeClass("display_none");
        $($generalAdvicesDiv).append($newAdvice);
        $(".addGeneralAdviceOption").removeClass('error');

    });

    // remove section
    $("body").on("click", ".removeSection", function() {
        var sectionDiv = $(this).closest(".sectionDiv");
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

    // add question to section
    $("body").on("click", ".addQuestion", function() {
        $questionsDiv = $(this)
            .parents(".addQuestionOption")
            .siblings("#QuestionsDiv");
        $newQuestion = $("#QuestionTemp")
            .clone()
            .removeClass("display_none")
            .attr("id", "");
        $($questionsDiv).removeClass("display_none");
        $($questionsDiv).append($newQuestion);
    });

    // remove question
    $("body").on("click", ".removeQuestion", function() {
        var questionDiv = $(this).closest(".questionDiv");
        var questionsDiv = $(this).parents("#QuestionsDiv");
        $(questionDiv).slideUp(500, function() {
            $(this).remove();
            if ($(questionsDiv).find(".questionDiv").length == 0) {
                $(questionsDiv).addClass("display_none");
            }
        });
    });

    // select question type
    $("body").on("change", ".selectQuestionType", function() {
        $selected = $(this);
        $question = $($selected).parents(".questionDiv");
        $type = $($selected).val();
        $($question).attr("type", $type);
        $($question).find("#AnswersDiv").find(".answerDiv").remove();
        if ($type == "rate" || $type == "text" || $type == "toggle") {
            $($question).find(".addAnswerOption").addClass("display_none");
            $($question).find("#AnswersDiv").addClass("display_none");
        } else {
            $($question).find(".addAnswerOption").removeClass("display_none");
        }
        if ($type == "amount") {
            $answersDiv = $($question).find("#AnswersDiv");
            $newAnswer = $("#AmountAnswerTemp")
                .clone()
                .removeClass("display_none")
                .attr("id", "");
            $($answersDiv).removeClass("display_none");
            $($question).find(".addAnswerOption").addClass("display_none");
            $($answersDiv).append($newAnswer);
        }
    });

    // add Answer to question
    $("body").on("click", ".addAnswer", function() {
        $addAnswerButton = this;
        $answersDiv = $(this)
            .parents(".addAnswerOption")
            .siblings("#AnswersDiv");
        $newAnswer = $("#AnswerTemp")
            .clone()
            .removeClass("display_none")
            .attr("id", "");
        console.log($("#AnswerTemp"));
        $($answersDiv).removeClass("display_none");
        $($answersDiv).append($newAnswer);
        hideErrors($($addAnswerButton).parents('.questionDiv '))
    });

    // remove answer
    $("body").on("click", ".removeAnswer", function() {
        var answerDiv = $(this).closest(".answerDiv");
        var answersDiv = $(answerDiv).parents("#AnswersDiv");
        $(answerDiv)
            .closest(".answerDiv")
            .slideUp(500, function() {
                $(this).remove();
                if ($(answersDiv).find(".answerDiv").length == 0) {
                    $(answersDiv).addClass("display_none");
                }
            });
    });

    // add Advice to answer
    $("body").on("click", ".addAdvice", function() {
        $addAdviceButton = this;
        $advicesDiv = $(this)
            .parents(".addAdviceOption")
            .siblings("#AdvicesDiv");
        $newAdvice = $("#AdviceTemp")
            .clone()
            .removeClass("display_none")
            .attr("id", "");
        $($advicesDiv).removeClass("display_none");
        $($advicesDiv).append($newAdvice);
    });

    // remove answer
    $("body").on("click", ".removeAdvice", function() {
        var adviceDiv = $(this).closest(".adviceDiv");
        var advicesDiv = $(adviceDiv).parents("#AdvicesDiv");

        $(adviceDiv).slideUp(500, function() {
            $(this).remove();
            if ($(advicesDiv).find(".adviceDiv").length == 0) {
                $(advicesDiv).addClass("display_none");
            }
        });
    });

    //submit survey form
    $("body").on("submit", "#SurveyForm", function(event) {
        event.preventDefault();
        $form = $(this);
        $submit = $("#submit");
        $($submit).prop("disabled", true);
        let survey_id = $form.find("input[name='survey_id']").val();
        let name = $form.find("input[name='name']");
        let name_en = $form.find("input[name='name_en']");
        let slug = $form.find("input[name='slug']");
        let slug_en = $form.find("input[name='slug_en']");
        let description = $form.find("textarea[name='description']");
        let description_en = $form.find("textarea[name='description_en']");
        let intro = $form.find("textarea[name='intro']");
        let intro_en = $form.find("textarea[name='intro_en']");
        let start_date = $form.find("input[name='start_date']");
        let end_date = $form.find("input[name='end_date']");
        let survey_image = $form.find("input[name='survey_image']")[0];
        if (
            name.val() != "" &&
            name_en.val() != "" &&
            slug.val() != "" &&
            slug_en.val() != "" &&
            description.val() != "" &&
            description_en.val() != "" &&
            intro.val() != "" &&
            intro_en.val() != "" &&
            end_date.val() != "" &&
            start_date.val() != "" &&
            (survey_id != undefined ? true : survey_image.files[0] != undefined)
        ) {
            hideErrors($(".survey_data"));
            $sections = $($form).find("#SectionsDiv").find(".sectionDiv"); //get survey sections
            let section_error = false;
            let validated_sections = [];
            if ($sections.length == 0) {
                $($submit).prop("disabled", false);
                return false;
            }
            $.each($sections, function(key, section) {
                let validated_section = sectionValidation(section, survey_id);

                if (!validated_section) {
                    section_error = true;
                    return false;
                }
                validated_sections.push(validated_section);
            });
            if (!section_error) {
                let surveyObj = {
                    survey_id: survey_id,
                    name: { ar: name.val(), en: name_en.val() },
                    slug: { ar: slug.val(), en: slug_en.val() },
                    description: {
                        ar: description.val(),
                        en: description_en.val(),
                    },
                    intro: { ar: intro.val(), en: intro_en.val() },
                    start_date: start_date.val(),
                    end_date: end_date.val(),
                    sections: validated_sections,
                    _token: $('input[name="_token"]').val(),
                };
                console.log(surveyObj);
                $.ajax({
                        type: $('input[name="_method"]').val(),
                        url: $form.attr("action"),
                        data: surveyObj,
                    })
                    .done(function(data) {
                        if (data["error_status"]) {
                            displayErrors(data["errors"]);
                            $($submit).prop("disabled", false);
                        } else {
                            uploadSurveyImage(data.data.id);
                            $($submit).prop("disabled", false);
                        }
                    })
                    .fail(function(data) {
                        $($submit).prop("disabled", false);
                    });
            } else {
                $($submit).prop("disabled", false);
            }
        } else {
            if (name.val() == "") {
                showError(".survey_data", name, "ar");
            }
            if (name_en.val() == "") {
                showError(".survey_data", name_en, "ar");
            }
            if (slug.val() == "") {
                showError(".survey_data", slug);
            }
            if (description.val() == "") {
                showError(".survey_data", description, "ar");
            }
            if (description_en.val() == "") {
                showError(".survey_data", description_en, "en");
            }
            if (intro.val() == "") {
                showError(".survey_data", intro, "ar");
            }
            if (intro_en.val() == "") {
                showError(".survey_data", intro_en, "en");
            }
            if (start_date.val() == "") {
                showError(".survey_data", start_date);
            }
            if (end_date.val() == "") {
                showError(".survey_data", end_date);
            }
            if (survey_id == undefined && survey_image.files[0] == undefined) {
                showError(".survey_data", survey_image);
            }

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

    function uploadSurveyImage(id) {
        var form = $("#SurveyForm")[0];
        var form_data = new FormData(form);
        form_data.append("id", id);
        $.ajax({
            url: $("#upload").val(),
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(data) {
                window.location.replace($("#browse").val());
            },
            error: function() {
                window.location.replace($("#browse").val());
            },
        });
    }

    function sectionValidation(section, survey_id = undefined) {
        let validated = false;

        let title = $(section).find("input[name='section_title']");
        let title_en = $(section).find("input[name='section_title_en']");
        let description = $(section).find(
            "textarea[name='section_description']"
        );
        let description_en = $(section).find(
            "textarea[name='section_description_en']"
        );
        let image = $(section).find("input[name='image[]']")[0];
        if (
            title.val() != "" &&
            title_en.val() != "" &&
            description.val() != "" &&
            description_en.val() != "" &&
            (survey_id != undefined ? true : image.files[0] != undefined)
        ) {
            $questions = $(section).find("#QuestionsDiv").find(".questionDiv"); // get section questions
            let validated_questions = [];
            let question_error = false;
            if ($questions.length == 0) {
                showError(section, null);
                return validated;
            } else {
                $.each($questions, function(key, question) {
                    $validated_q = questionValidation(question);
                    if (!$validated_q) {
                        question_error = true;
                        return false;
                    }
                    validated_questions.push($validated_q);
                });
            }

            if (!question_error) {
                hideErrors(section);

                validated = {
                    title: { ar: title.val(), en: title_en.val() },
                    description: {
                        ar: description.val(),
                        en: description_en.val(),
                    },
                    questions: validated_questions,
                };
            }
        } else {
            if (!(title.val() != "")) {
                showError(section, title, "ar");
            }
            if (!(title_en.val() != "")) {
                showError(section, title_en, "en");
            }
            if (!(description.val() != "")) {
                showError(section, description, "ar");
            }
            if (!(description_en.val() != "")) {
                showError(section, description_en, "en");
            }
            if (survey_id == undefined && image.files[0] == undefined) {
                showError(section, image);
            }
        }

        return validated;
    }

    function questionValidation(question) {
        let type = $(question).find("select[name='type']").val();
        let text = $(question).find("input[name='question']");
        let text_en = $(question).find("input[name='question_en']");
        var validated = false;
        var question_types = [
            "text",
            "radio",
            "checkbox",
            "toggle",
            "dropdown",
            "amount",
            "rate",
        ];

        if (
            text.val() != "" &&
            text_en.val() != "" &&
            question_types.indexOf(type) != -1
        ) {
            let validated_answers = [];
            let answer_error = false;

            if (!(type == "rate" || type == "text" || type == "toggle")) {
                $answers = $(question).find("#AnswersDiv").find(".answerDiv"); // get question answers
                if ($answers.length == 0) {
                    showError(question, null);
                    answer_error = true;
                } else {
                    $.each($answers, function(key, answer) {
                        validated_answer = answerValidation(answer, type);

                        if (validated_answer) {
                            validated_answers.push(validated_answer);
                        } else {
                            answer_error = true;
                            return false;
                        }
                    });
                }
            }

            if (!answer_error) {
                validated = {
                    type: type,
                    text: { ar: text.val(), en: text_en.val() },
                    answers: validated_answers,
                };
            }
        } else {
            if (!(text.val() != "")) {
                showError(question, text, "ar");
            }
            if (!(text_en.val() != "")) {
                showError(question, text_en, "en");
            }
            if (!(question_types.indexOf(type) != -1)) {
                showError(question, type);
            }
        }

        return validated;
    }

    function answerValidation(answer, question_type) {
        let validated = false;

        let text = $(answer).find("input[name='answer']");
        let text_en = $(answer).find("input[name='answer_en']");
        let order = $(answer).find("input[name='order']");
        let condition =
            question_type == "amount" ?
            text.val() != "" :
            text.val() != "" && text_en.val() != "" && order.val() != "";
        if (condition) {
            validated = {
                text: { ar: text.val(), en: text_en.val() },
                order: order.val(),
            };
            hideErrors(answer);
        } else {
            if (!(text.val() != "")) {
                showError(answer, $(answer).find("input[name='answer']"), "ar");
            }

            if (!(text_en.val() != "" && question_type != "amount")) {
                showError(
                    answer,
                    $(answer).find("input[name='answer_en']"),
                    "en"
                );
            }

            if (!(order.val() != "" && question_type != "amount")) {
                showError(answer, $(answer).find("input[name='order']"));
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

    function hideAllErrors() {
        $(".error").removeClass("error");
        $('.error_message').remove();
    }
    //submit survey form
    $("body").on("submit", "#RiskForm", function(event) {
        event.preventDefault();
        hideAllErrors()
        $form = $(this);
        $submit = $("#submit");
        $($submit).prop("disabled", true);
        let risk_id = $form.find("input[name='risk_id']").val();
        let slug_ar = $form.find("input[name='slug_ar']");
        let slug_en = $form.find("input[name='slug_en']");
        let title_ar = $form.find("input[name='title_ar']");
        let title_en = $form.find("input[name='title_en']");
        let description_ar = $form.find("textarea[name='description_ar']");
        let description_en = $form.find("textarea[name='description_en']");
        let gender = $form.find("input[name='gender']:checked");
        let age_from = $form.find("input[name='age_from']");
        let age_to = $form.find("input[name='age_to']");
        let risk_image = $form.find("input[name='risk_image']")[0];
        let recommended_actions_checked = $form.find(
            "input[name='recommended_actions[]']:checked"
        );
        let category_id = $form.find("[name='category_id']").val()

        if ($('.risk_status').is(':checked')) {
            var checkedValue = 1;
        } else {
            var checkedValue = 0;
        }

        let speciality_id = $form.find('.speciality_id');

        var recommended_actions = [];

        $(recommended_actions_checked).each(function() {
            recommended_actions.push($(this).val());
        });

        hideErrors($(".risk_data"));
        $sections = $($form).find("#SectionsDiv").find(".sectionDiv"); //get risk sections
        let section_error = false;
        let validated_sections = [];

        $.each($sections, function(key, section) {
            let validated_section = riskSectionValidation(section, risk_id);
            validated_sections.push(validated_section);
        });

        $advices = $($form).find("#GeneralAdvicesDiv").find(".adviceDiv"); //get risk advices
        let advices_error = false;
        let validated_advices = [];

        $.each($advices, function(key, advice) {
            let validated_advice = riskAdviceValidation(advice);
            validated_advices.push(validated_advice);
        });

        let surveyObj = {
            risk_id: risk_id,
            slug: { ar: slug_ar.val(), en: slug_en.val() },
            title: { ar: title_ar.val(), en: title_en.val() },
            description: { ar: description_ar.val(), en: description_en.val() },
            age_from: age_from.val(),
            age_to: age_to.val(),
            sections: validated_sections,
            gender: gender.val(),
            actions: JSON.stringify(recommended_actions),
            speciality_id: speciality_id.val(),
            advices: validated_advices,
            risk_image: 1,
            category_id: category_id,
            status: checkedValue,
            _token: $('input[name="_token"]').val(),
        };

        if (risk_image.files[0] == undefined && risk_id == null) {
            delete surveyObj.risk_image

        } else if (risk_image.files[0] != undefined && risk_image.files[0].size > 5000) {
            surveyObj.risk_image = 6000
        }


        //     console.log(surveyObj);
        $.ajax({
            type: $('input[name="_method"]').val(),
            url: $form.attr('action'),
            data: surveyObj,
        }).done(function(data) {
            console.log(data);

            if (data['error_status']) {
                displayErrors(data['errors']);
                $($submit).prop('disabled', false);
            } else {
                uploadRiskImage(data.data.id);
                // $($submit).prop('disabled', false);
            }
        }).fail(function(data) {
            showBackEndErrors(data.responseJSON.errors)
            $($submit).prop('disabled', false);
        });
        //     } else {
        //         $($submit).prop("disabled", false);
        //     }
        // } else {
        //     if (title_ar.val() == "") {
        //         showError(".risk_data", title_ar, "ar");
        //     }
        //     if (title_en.val() == "") {
        //         showError(".risk_data", title_en, "en");
        //     }
        //     if (description_ar.val() == "") {
        //         showError(".risk_data", description_ar, "ar");
        //     }
        //     if (description_en.val() == "") {
        //         showError(".risk_data", description_en, "en");
        //     }

        //     if (gender.length == 0) {
        //         showError(".risk_data", $(".gender"));
        //     }

        //     if (age_from.val() == "") {
        //         showError(".risk_data", age_from);
        //     }
        //     if (age_to.val() == "") {
        //         showError(".risk_data", age_to);
        //     }
        //     if (risk_id == undefined && risk_image.files[0] == undefined) {
        //         showError(".risk_data", risk_image);
        //     }

        //     if (recommended_actions.length == 0) {
        //         showError(".risk_data", $(".recommended_actions"));
        //     }

        //     if (speciality_id.val() == null) {
        //         showError(".risk_data", speciality_id);
        //     }

        //     $($submit).prop("disabled", false);
        // }
    });

    function riskSectionValidation(section, risk_id = undefined) {
        let validated = false;

        let title_ar = $(section).find("input[name='title_ar']");
        let title_en = $(section).find("input[name='title_en']");

        let slug_ar = $(section).find("input[name='slug_ar']");
        let slug_en = $(section).find("input[name='slug_en']");

        // if (title_ar.val() != "" && title_en.val() != "") {
        $questions = $(section).find("#QuestionsDiv").find(".questionDiv"); // get section questions
        let validated_questions = [];
        let question_error = false;
        // if ($questions.length == 0) {
        //     showError(section, null);
        //     return validated;
        // } else {
        $.each($questions, function(key, question) {
            $validated_q = riskQuestionValidation(question);
            if (!$validated_q) {
                question_error = true;
                return false;
            }
            validated_questions.push($validated_q);
        });
        // }

        // if (!question_error) {
        //     hideErrors(section);

        validated = {
            title: { ar: title_ar.val(), en: title_en.val() },
            slug: { ar: slug_ar.val(), en: slug_en.val() },
            questions: validated_questions,
        };
        // }
        // } else {
        //     if (!(title_ar.val() != "")) {
        //         showError(section, title_ar, "ar");
        //     }
        //     if (!(title_en.val() != "")) {
        //         showError(section, title_en, "en");
        //     }
        // }

        return validated;
    }

    function riskQuestionValidation(question) {
        let type = $(question).find("select[name='type']").val();
        let name_ar = $(question).find("textarea[name='name_ar']");
        let name_en = $(question).find("textarea[name='name_en']");
        var validated = false;
        var question_types = ["radio", "checkbox", "dropdown"];

        // if (
        //     name_ar.val() != "" &&
        //     name_en.val() != "" &&
        //     question_types.indexOf(type) != -1
        // ) {
        let validated_answers = [];
        let answer_error = false;

        $answers = $(question).find("#AnswersDiv").find(".answerDiv"); // get question answers
        // if ($answers.length < 1) {
        //     showError(question, $(question).find('.addAnswerOption'), null);
        //     answer_error = true;
        // } else {
        $.each($answers, function(key, answer) {
            validated_answer = riskAnswerValidation(answer, type);

            // if (validated_answer) {
            validated_answers.push(validated_answer);
            // } else {
            //     answer_error = true;
            //     return false;
            // }
        });
        // }

        // if (!answer_error) {
        validated = {
            type: type,
            name: { ar: name_ar.val(), en: name_en.val() },
            answers: validated_answers,
            is_required: $(question)
                .find("input[name='required']")
                .is(":checked") == true ? 1 : 0,
        };
        // }
        // } else {
        //     if (!(name_ar.val() != "")) {
        //         showError(question, name_ar, "ar");
        //     }
        //     if (!(name_en.val() != "")) {
        //         showError(question, name_en, "en");
        //     }
        //     if (!(question_types.indexOf(type) != -1)) {
        //         showError(question, type);
        //     }
        // }

        return validated;
    }

    function riskAnswerValidation(answer, question_type) {
        let validated = false;

        let text_ar = $(answer).find("input[name='name_ar']");
        let text_en = $(answer).find("input[name='name_en']");
        let score = $(answer).find("input[name='score']");
        let advice_error = false;

        // if (text_ar.val() != "" && text_en.val() != "" && score.val() != "") {
        let validated_advices = [];
        let answer_error = false;

        $advices = $(answer).find("#AdvicesDiv").find(".adviceDiv"); // get question answers
        // if ($advices.length == 0) {
        //     showError(answer, null);
        //     answer_error = true;
        // } else {
        $.each($advices, function(key, advice) {
            validated_advice = riskAdviceValidation(advice);

            // if (validated_advice) {
            validated_advices.push(validated_advice);
            // } else {
            //     advice_error = true;
            //     return false;
            // }
        });
        // }

        // if (!advice_error) {
        validated = {
            name: { ar: text_ar.val(), en: text_en.val() },
            score_value: score.val(),
            advices: validated_advices,
        };
        hideErrors(answer);
        // }
        // } else {
        //     if (!(text_ar.val() != "")) {
        //         showError(answer, text_ar, "ar");
        //     }

        //     if (!(text_en.val() != "" && question_type != "amount")) {
        //         showError(answer, text_en, "en");
        //     }

        //     if (score.val() == "") {
        //         showError(answer, score);
        //     }
        // }
        return validated;
    }

    function riskAdviceValidation(advice) {
        let validated = false;

        let name_ar = $(advice).find("input[name='name_ar']");
        let name_en = $(advice).find("input[name='name_en']");
        let type = $(advice).find("[name='type']");

        // if (name_ar.val() != "" && name_en.val() != "") {
        validated = {
            name: { ar: name_ar.val(), en: name_en.val() },
            type: type.val()
        };
        //     hideErrors(advice);
        // } else {
        //     console.log(advice);
        //     if (name_ar.val() == "") {
        //         showError(
        //             advice,
        //             $(advice).find("input[name='name_ar']"),
        //             "ar"
        //         );
        //     }

        //     if (name_en.val() == "") {
        //         showError(
        //             advice,
        //             $(advice).find("input[name='name_en']"),
        //             "en"
        //         );
        //     }
        // }
        return validated;
    }

    function uploadRiskImage(id) {

        $("input[name='_method']").remove();
        var form = $("#RiskForm")[0];
        var form_data = new FormData(form);
        form_data.append("id", id);
        $.ajax({
            url: $("#upload").val(),
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(data) {
                var redirect = $("#browse").val() + '/' + id;
                window.location.replace(redirect);
            },
            error: function() {
                window.location.replace($("#browse").val());
            },
        });
    }

    function handleShowRiskError(keys, errorMessage) {
        if (keys[0] == 'sections') {
            showError($('.addSectionOption'), $('.addSectionOption').find('.addSection'), null, errorMessage);
            return
        } else if (keys[0] == 'gender') {
            showError($('.gender '), $('.gender '), null, errorMessage);
            return;
        } else if (keys[0] == 'speciality_id') {
            showError($("[name='speciality_id']"), $("[name='speciality_id']"), null, errorMessage);
            return;
        }
        let keyLen = keys.length;
        if (keyLen == 1) {
            showError($('.risk_data'), $('.risk_data').find(`[name='${keys[0]}']`), null, errorMessage);
        } else {
            showError($('.risk_data'), $('.risk_data').find(`[name='${keys[0]}_${keys[1]}']`), keys[1], errorMessage);
        }
    }


    function handleShowSectionsError(keys, errorMessage) {
        if (keys[0] == 'advices' && keys[2] == 'name') {
            showError($("#GeneralAdvicesDiv"), $($("#GeneralAdvicesDiv").find('.adviceDiv')[keys[1]]).find(`[name='name_${keys[3]}']`), null, errorMessage);
            return;
        }

        if (keys[0] == 'advices' && keys[2] == 'type') {
            console.log(errorMessage)
            showError($("#GeneralAdvicesDiv"), $($("#GeneralAdvicesDiv").find('.adviceDiv')[keys[1]]).find(`[name='type']`), null, errorMessage);
            return;
        }

        if (keys.length == 3) {
            showError(null,
                $($('#SectionsDiv').find('.sectionDiv')[parseInt(keys[1])]).find('.addQuestionOption').find('input'),
                keys[3],
                errorMessage);
            return
        }
        showError($('#SectionsDiv').find('.sectionDiv')[parseInt(keys[1])],
            $($('#SectionsDiv').find('.sectionDiv')[parseInt(keys[1])]).find(`[name='title_${keys[3]}']`),
            keys[3],
            errorMessage);
    }

    function handleShowQuestionsError(keys, errorMessage) {
        let keyLen = keys.length;
        if (keys[4] == 'answers') {
            showError($($('#SectionsDiv').find('.sectionDiv ')[parseInt(keys[1])]).find("#QuestionsDiv").find('.questionDiv')[parseInt(keys[3])],
                $($($('#SectionsDiv').find('.sectionDiv ')[parseInt(keys[1])]).find("#QuestionsDiv").find('.questionDiv')[parseInt(keys[3])]).find('.addAnswerOption'),
                keys[5],
                errorMessage);
            return;
        }
        let parent_div = $($('#SectionsDiv').find('.sectionDiv ')[parseInt(keys[1])]).find("#QuestionsDiv").find('.questionDiv')[parseInt(keys[3])];
        if (keyLen == 6) {
            showError(parent_div,
                $(parent_div).find(`textarea[name='name_${keys[5]}']`),
                keys[5],
                errorMessage);
        } else {
            showError(parent_div,
                $(parent_div).find(`[name='type']`),
                null,
                errorMessage);
        }

    }

    function handleShowAnswerError(keys, errorMessage) {
        let keyLen = keys.length;
        let parent_div = $($($('#SectionsDiv').find('.sectionDiv ')[parseInt(keys[1])]).find("#QuestionsDiv").find('.questionDiv')[parseInt(keys[3])]).find('#AnswersDiv').find('.answerDiv')[parseInt(keys[5])];
        if (keyLen == 8) {
            showError(parent_div,
                $(parent_div).find(`[name='name_${keys[7]}']`),
                keys[8],
                errorMessage);
        } else {
            showError(parent_div,
                null,
                keys[6],
                errorMessage);
        }
    }

    function handleShowAnswerAdviceError(keys, errorMessage) {
        let keyLen = keys.length;
        let parent_div = $($($($('#SectionsDiv').find('.sectionDiv ')[keys[1]]).find("#QuestionsDiv").find('.questionDiv')[parseInt(keys[3])]).find('#AnswersDiv').find('.answerDiv')[parseInt(keys[5])]).find('#AdvicesDiv').find('.adviceDiv')[parseInt(keys[7])];
        if (keyLen == 10) {
            showError(parent_div,
                $(parent_div).find(`[name='advice_${keys[9]}']`),
                keys[9],
                errorMessage);
        }
    }

    function handleAnswerAdviceError(keys, errorMessage) {
        let keyLen = keys.length;
        let parent_div = $($($($('#SectionsDiv').find('.sectionDiv ')[keys[1]]).find("#QuestionsDiv").find('.questionDiv')[parseInt(keys[3])]).find('#AnswersDiv').find('.answerDiv')[parseInt(keys[5])]).find('#AdvicesDiv').find('.adviceDiv')[parseInt(keys[7])];
        if (keyLen == 9) {
            console.log(parent_div, $(parent_div).find(`[name='type']`))
            showError(parent_div,
                $(parent_div).find(`[name='type']`),
                keys[9],
                errorMessage);
        }
    }

    let handleServerError = {
        1: handleShowRiskError, // risk =>  age_from, age_to , image, gender & actions
        2: handleShowRiskError, // title & desc => title.ar , desc.ar , title.en & desc.en
        4: handleShowSectionsError, // generalAdvices & sections data
        3: handleShowSectionsError, // generalAdvices & sections data
        6: handleShowQuestionsError, // question data
        5: handleShowQuestionsError, // question "type"
        8: handleShowAnswerError, // answer text
        7: handleShowAnswerError, // answer score
        9: handleAnswerAdviceError, // answer score
        10: handleShowAnswerAdviceError, //  answer advices text
    }

    function showBackEndErrors(errors) {
        for (const property in errors) {
            keys = property.split(".");
            console.log(keys, property, errors[property]);
            handleServerError[`${keys.length}`](keys, errors[property])
        }

    }

});