document.addEventListener("DOMContentLoaded", function () {
    // Initialize CodeMirror editors - now Python first, then Java
    const pythonEditor = CodeMirror.fromTextArea(document.getElementById("pythonCodeEditor"), {
        lineNumbers: true,
        theme: "monokai",
        mode: "text/x-python",
        indentUnit: 4,
        indentWithTabs: true,
        autoCloseBrackets: true,
        matchBrackets: true,
        lineWrapping: true,
        readOnly: false // Make Python editable now as it's the first box
    });

    // Java editor is now second 
    const javaEditor = CodeMirror.fromTextArea(document.getElementById("javaCodeEditor"), {
        lineNumbers: true,
        theme: "monokai",
        mode: "text/x-java",
        indentUnit: 4,
        indentWithTabs: true,
        autoCloseBrackets: true,
        matchBrackets: true,
        lineWrapping: true
    });
    
    // Set appropriate heights
    pythonEditor.setSize(null, 320);
    javaEditor.setSize(null, 320);

    // Word count variables and limits
    const wordCountSpan = document.getElementById("wordCount");
    const wordLimitBeginner = 50;
    const wordLimitExpert = 200;
    let currentWordLimit = wordLimitBeginner; // Default to beginner

    // Function to count words in text
    function countWords(text) {
        // Remove comments
        text = text.replace(/\/\*[\s\S]*?\*\/|\/\/.*/g, '');
        // Remove extra whitespace and split by whitespace
        return text.trim().split(/\s+/).filter(Boolean).length;
    }

    // Function to update word count display
    function updateWordCount() {
        const javaCode = javaEditor.getValue();
        const wordCount = countWords(javaCode);
        const isOverLimit = wordCount > currentWordLimit;
        
        // Update the counter with current/max format
        wordCountSpan.textContent = `${wordCount}/${currentWordLimit} words`;
        
        // Highlight if over limit
        if (isOverLimit) {
            wordCountSpan.style.color = '#dc3545'; // Red color
            wordCountSpan.style.fontWeight = 'bold';
        } else {
            wordCountSpan.style.color = '#6c757d'; // Original color
            wordCountSpan.style.fontWeight = 'normal';
        }
        
        return wordCount;
    }

    // Add event listener for changes in Java editor
    javaEditor.on('change', function() {
        updateWordCount();
    });

    // User level variables
    let userLevel = localStorage.getItem('userPythonLevel') || '';
    
    // If no user level is stored, show the selection modal
    if (!userLevel) {
        $('#levelSelectionModal').modal('show');
    } else {
        updateUIForUserLevel(userLevel);
    }
    // Event listeners for level selection
    document.getElementById("beginnerLevelBtn").addEventListener("click", function() {
        setUserLevel('beginner');
        $('#levelSelectionModal').modal('hide');
    });
    
    document.getElementById("expertLevelBtn").addEventListener("click", function() {
        setUserLevel('expert');
        $('#levelSelectionModal').modal('hide');
    });
    
    // Mode toggle input handler
    const modeToggleInput = document.getElementById("modeToggleInput");
    if (modeToggleInput) {
        // Set initial state based on current mode
        modeToggleInput.checked = userLevel === 'expert';
        
        // Add event listener for toggle
        modeToggleInput.addEventListener("change", function() {
            setUserLevel(this.checked ? 'expert' : 'beginner');
        });
    }
    
    // Function to set user level and update UI
    function setUserLevel(level) {
        userLevel = level;
        localStorage.setItem('userPythonLevel', level);
        updateUIForUserLevel(level);
    }
    
    // Function to update UI based on user level
    function updateUIForUserLevel(level) {
        const modeIndicator = document.getElementById("currentModeIndicator");
        const modeSwitchText = document.getElementById("modeSwitchText");
        const modeToggleInput = document.getElementById("modeToggleInput");
        const tipSection = document.getElementById("tipSection");
        
        if (level === 'beginner') {
            modeIndicator.innerHTML = '<i class="fas fa-graduation-cap"></i> Learning Mode';
            modeIndicator.className = 'text-primary';
            modeSwitchText.textContent = 'Switch to Professional Mode';
            tipSection.style.display = 'block';
            if (modeToggleInput) modeToggleInput.checked = false;
            // Set word limit for beginner mode
            currentWordLimit = wordLimitBeginner;
        } else {
            modeIndicator.innerHTML = '<i class="fas fa-code"></i> Professional Mode';
            modeIndicator.className = 'text-success';
            modeSwitchText.textContent = 'Switch to Learning Mode';
            tipSection.style.display = 'none';
            if (modeToggleInput) modeToggleInput.checked = true;
            // Set word limit for expert mode
            currentWordLimit = wordLimitExpert;
        }
        
        // Update word count display to reflect new limit
        updateWordCount();
    }

    let convertBtn = document.getElementById("convertBtn");
    let saveBtn = document.getElementById("saveBtn");
    let runPythonBtn = document.getElementById("runPythonBtn");
    let pythonOutput = document.getElementById("pythonOutput");
    let conversionTitle = document.getElementById("conversionTitle");
    let newConversionBtn = document.getElementById("newConversionBtn");

    // Variables for input handling
    let pythonInputContainer = document.getElementById("pythonInputContainer");
    let pythonUserInput = document.getElementById("pythonUserInput");
    let pythonSubmitInput = document.getElementById("pythonSubmitInput");
    
    // Keep track of pending input requests
    let pythonInputCallback = null;

    let pythonCode = "";
    let explanation = "";
    let tips = "";
    let currentConversionId = null;

    // Configure Skulpt for Python execution
    function outf(text) {
        pythonOutput.textContent += text;
    }
    
    function builtinRead(x) {
        if (Sk.builtinFiles === undefined || Sk.builtinFiles["files"][x] === undefined)
            throw "File not found: '" + x + "'";
        return Sk.builtinFiles["files"][x];
    }

    // Custom input function for Python
    function inputHandler(prompt) {
        return new Promise(function(resolve, reject) {
            // Show the input container
            pythonOutput.textContent += prompt;
            pythonInputContainer.style.display = "block";
            
            // Store the callback to resolve the promise later
            pythonInputCallback = function(value) {
                // Add the input value to the output display
                pythonOutput.textContent += value + "\n";
                resolve(value);
            };
            
            // Focus on the input field
            pythonUserInput.focus();
        });
    }

    // Handle Python input submission
    pythonSubmitInput.addEventListener("click", function() {
        if (pythonInputCallback) {
            const value = pythonUserInput.value;
            const callback = pythonInputCallback;
            
            // Reset for next input
            pythonUserInput.value = "";
            pythonInputContainer.style.display = "none";
            pythonInputCallback = null;
            
            // Call the callback with the input value
            callback(value);
        }
    });
    
    // Also handle Enter key for Python input
    pythonUserInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter" && !event.shiftKey) {
            event.preventDefault();
            pythonSubmitInput.click();
        }
    });

    // Override setValue to directly show model output but keep it editable
    const originalSetValue = pythonEditor.setValue;
    pythonEditor.setValue = function(value) {
        if (value && typeof value === 'string') {
            // Display the raw output from model without formatting
            originalSetValue.call(this, value);
            this.refresh();
        } else {
            originalSetValue.call(this, '');
        }
    };
    
    // Helper: scroll output to bottom
    function scrollToBottom(el) {
        el.scrollTop = el.scrollHeight;
    }

    // Run Python code
    runPythonBtn.addEventListener("click", function() {
        pythonOutput.textContent = "";
        pythonInputContainer.style.display = "none";
        pythonInputCallback = null;
        
        let pythonCode = pythonEditor.getValue();
        if (!pythonCode.trim()) {
            pythonOutput.textContent = "No Python code to run.";
            return;
        }
        
        try {
            Sk.pre = "pythonOutput";
            Sk.configure({
                output: outf, 
                read: builtinRead,
                __future__: Sk.python3,
                inputfun: inputHandler
            });
            
            Sk.misceval.asyncToPromise(function() {
                return Sk.importMainWithBody("<stdin>", false, pythonCode, true);
            }).then(function() {
                // Execution completed successfully
            }).catch(function(err) {
                pythonOutput.textContent += "\nError: " + err.toString();
            });
        } catch (e) {
            pythonOutput.textContent += "\nError: " + e.toString();
        }
    });

    // New Conversion button event listener
    newConversionBtn.addEventListener("click", function() {
        // Reset all variables completely
        pythonEditor.setValue("");
        pythonEditor.setOption("readOnly", false); // Ensure Python editor is editable
        pythonOutput.textContent = "Output will be displayed here after running Python code.";
        conversionTitle.value = "";
        javaEditor.setValue("");
        pythonCode = "";
        explanation = "";
        tips = "";
        
        // Very important: Reset the currentConversionId to null for new conversions
        currentConversionId = null;
        
        // Reset execution time display (clear text but don't hide)
        const executionTimeDisplay = document.getElementById("executionTimeDisplay");
        if (executionTimeDisplay) {
            executionTimeDisplay.textContent = "";
            // Don't hide the element, just clear its content
        }
        
        // Hide tips section
        document.getElementById("tipSection").style.display = "none";
        
        // Remove id from URL if present
        const url = new URL(window.location.href);
        url.searchParams.delete('id');
        window.history.pushState({}, '', url);
    });

    // Load conversion if ID is in query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const conversionId = urlParams.get('id');
    if (conversionId) {
        currentConversionId = conversionId;
        loadConversion(conversionId);
    }

    // Update the convert button event listener
    convertBtn.addEventListener("click", function() {
        let javaCode = javaEditor.getValue().trim();
        
        // Check if Java code is empty
        if (!javaCode) {
            showEnhancedToast("Please enter Java code first.", "warning");
            return;
        }
        
        // Check if word count exceeds the limit based on mode
        const wordCount = updateWordCount();
        if (wordCount > currentWordLimit) {
            const mode = userLevel === 'beginner' ? 'Learning' : 'Professional';
            showEnhancedToast(`Java code exceeds the ${currentWordLimit} word limit for ${mode} Mode.`, "warning");
            // Highlight the word count
            wordCountSpan.style.color = '#dc3545';
            wordCountSpan.style.fontWeight = 'bold';
            return;
        }

        // Set loading state
        pythonEditor.setOption("readOnly", true); // Make Python editor readonly during conversion
        pythonEditor.setValue("Converting code...");
        
        // Get the execution time display
        let executionTimeDisplay = document.getElementById("executionTimeDisplay");
        let tipSection = document.getElementById("tipSection");
        let tipContent = document.getElementById("tipContent");
        
        // Reset position if needed
        const buttonContainer = document.querySelector(".button-container");
        if (buttonContainer && executionTimeDisplay.parentNode !== buttonContainer) {
            buttonContainer.appendChild(executionTimeDisplay);
        }
        
        // Add loading indicator
        executionTimeDisplay.textContent = "⏱️ ...";
        
        // Hide tip section until we get a response
        tipSection.style.display = "none";

        const formData = new FormData();
        formData.append('java_code', javaCode);
        formData.append('level_cs', userLevel || 'beginner'); // Add level_cs parameter
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('save_mode', 'convert');

        fetch(window.syntaxConverterConvertRoute, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Check if any of the response fields contains "404"
            const has404 = 
                (data.python_code && data.python_code.includes("404")) || 
                (data.explanation && data.explanation.includes("404")) || 
                (data.tips && data.tips.includes("404"));
            
            if (has404) {
                // Override with error messages if any field has 404
                pythonCode = "Syntax tidak support di mode belajar";
                explanation = "Mode belajar hanya dapat mengonversi sintaks Java dasar. <a href='" + 
                              window.location.origin + "/syntax-converter/guide" + 
                              "' class='text-primary'>Lihat ketentuan di sini</a>";
                tips = "Tidak ada Python tips untuk syntax yang tidak support";
                
                pythonEditor.setValue(pythonCode);
                pythonEditor.setOption("readOnly", false);
                
                if (executionTimeDisplay) {
                    executionTimeDisplay.textContent = "";
                }
                
                // Display tips section with the error message
                if (tipContent) {
                    tipContent.textContent = tips;
                    tipSection.style.display = "block";
                }
            } else {
                // Normal processing for successful conversion
                pythonCode = data.python_code || "Conversion failed.";
                explanation = data.explanation || "Explanation not available.";
                tips = data.tips || "";
                
                pythonEditor.setValue(pythonCode);
                pythonEditor.setOption("readOnly", false);
                
                if (data.execution_time) {
                    executionTimeDisplay.textContent = `⏱️ ${data.execution_time}s`;
                } else {
                    executionTimeDisplay.textContent = "";
                }
                
                if (userLevel === 'beginner' && tips) {
                    tipContent.textContent = tips;
                    tipSection.style.display = "block";
                } else {
                    tipSection.style.display = "none";
                }
            }
            
            // Reset and show feedback section with appropriate question
            resetFeedbackSection();
            
            // Set the appropriate question based on user level
            const feedbackQuestion = document.getElementById("feedbackQuestion");
            if (userLevel === 'beginner') {
                feedbackQuestion.textContent = "In your opinion, does this system help you learn a new programming language? 😊";
            } else {
                feedbackQuestion.textContent = "Does this tool improve ease of converting between different syntaxes? 🚀";
            }
            
            // Make sure the feedback section is visible but input container is hidden
            document.getElementById("feedbackSection").style.display = "block";
            document.getElementById("feedbackInputContainer").style.display = "none";
            
            // Re-attach listeners to ensure proper functionality
            attachFeedbackListeners();
        })
        .catch(error => {
            console.error("Error fetching conversion:", error);
            pythonEditor.setValue("An error occurred while connecting to the server!");
            pythonEditor.setOption("readOnly", false);
            explanation = "Explanation not available due to connection error.";
            
            if (executionTimeDisplay) {
                executionTimeDisplay.textContent = "";
            }
            tipSection.style.display = "none";
        });
    });

    // Modify loadConversion function to handle the changed order
    function loadConversion(id) {
        // Reset execution time display when loading from history
        const executionTimeDisplay = document.getElementById("executionTimeDisplay");
        if (executionTimeDisplay) {
            executionTimeDisplay.textContent = "";
        }
        
        fetch(window.syntaxConverterShowUrl.replace(':id', id))
            .then(response => response.json())
            .then(data => {
                conversionTitle.value = data.title;
                javaEditor.setValue(data.java_code);
                
                // Set Python code directly and make it editable
                if (data.python_code) {
                    pythonEditor.setValue(data.python_code);
                    pythonEditor.setOption("readOnly", false);
                }
                
                pythonOutput.textContent = "Output will be displayed here after running Python code.";
                explanation = data.explanation || "Explanation not available.";
                tips = data.tips || "";
                
                // Handle tips display based on user level
                const tipSection = document.getElementById("tipSection");
                const tipContent = document.getElementById("tipContent");
                
                if (userLevel === 'beginner' && tips) {
                    tipContent.textContent = tips;
                    tipSection.style.display = "block";
                } else {
                    tipSection.style.display = "none";
                }
                
                pythonCode = pythonEditor.getValue(); // Get the formatted code
                currentConversionId = id;
            })
            .catch(error => {
                console.error("Error loading conversion:", error);
            });
    }

    // Add the save button functionality
    saveBtn.addEventListener("click", function() {
        let javaCode = javaEditor.getValue().trim();
        let currentPythonCode = pythonEditor.getValue().trim();
        let currentExplanation = explanation.trim();
        let currentTips = tips || "";
        
        if (!javaCode) {
            showEnhancedToast("Java code is required before saving.", "warning");
            return;
        }

        if (!currentPythonCode) {
            showEnhancedToast("Please click Convert button first to get Python code.", "warning");
            return;
        }

        // Store whether this is a new conversion or an update
        const isNewConversion = !currentConversionId;

        // Disable the button during save and show loading state
        saveBtn.disabled = true;
        const originalButtonText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';

        // Show a "Saving..." toast
        showEnhancedToast("Saving conversion...", "info", false);

        const formData = new FormData();
        formData.append('java_code', javaCode);
        formData.append('python_code', currentPythonCode);
        formData.append('explanation', currentExplanation);
        formData.append('tips', currentTips);
        formData.append('level_cs', userLevel || 'beginner');
        formData.append('title', conversionTitle.value || 'Untitled Conversion');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('save_mode', 'save'); // Specify we're saving, not just converting
        
        // Append conversion_id if updating an existing history record
        if (currentConversionId) {
            formData.append('conversion_id', currentConversionId);
        }

        fetch(window.syntaxConverterConvertRoute, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // If we have a conversion ID from the response, update currentConversionId
            if (data.conversion_id) {
                // Update the history display and URL
                highlightHistoryItem(data.conversion_id);
                const url = new URL(window.location.href);
                url.searchParams.set('id', data.conversion_id);
                window.history.pushState({}, '', url);
                
                // Show success toast with the appropriate message based on the original state
                if (isNewConversion) {
                    showEnhancedToast("New conversion saved successfully! 🎉", "success");
                } else {
                    showEnhancedToast("Conversion updated successfully! ✓", "success");
                }
                
                // Set the currentConversionId for future updates
                currentConversionId = data.conversion_id;
            } else {
                showEnhancedToast("An error occurred while saving the conversion.", "danger");
            }
            
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalButtonText;
        })
        .catch(error => {
            console.error("Error saving conversion:", error);
            showEnhancedToast("An error occurred while saving the conversion: " + error.message, "danger");
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalButtonText;
        });
    });

    // Tambahkan event untuk tombol Penjelasan
    let showExplanationBtn = document.getElementById("showExplanationBtn");
    let modalExplanationContent = document.getElementById("modalExplanationContent");
    let explanationTableBody = document.getElementById("explanationTableBody");

    // Updated function to parse explanation into table format
    function formatExplanationAsTable(text) {
        if (!text || text.trim() === "") {
            return '<tr><td colspan="4" class="text-center">Explanation not available.</td></tr>';
        }
        
        // For expert mode - simple explanation should be in a table too
        if (userLevel === 'expert' || !text.includes("Java =")) {
            // Try to parse the explanation and check if it starts with numbers like "1. Python Code:"
            const pythonCodeMatch = text.match(/\d+\.\s+Python\s+Code\s*:\s*(```python[\s\S]*?```)/i);
            const explanationMatch = text.match(/\d+\.\s+Explanation\s*:\s*([\s\S]*?)(?=\d+\.|$)/i);
            
            if (pythonCodeMatch && explanationMatch) {
                const pythonCode = pythonCodeMatch[1].replace(/```python|```/g, '').trim();
                const explanation = explanationMatch[1].trim();
                
                return `
                    <tr>
                        <td>1</td>
                        <td><code class="code-block">${pythonCode.replace(/\n/g, '<br>')}</code></td>
                        <td><code class="code-block">${formatJavaCode()}</code></td>
                        <td>${formatPenjelasan(explanation)}</td>
                    </tr>
                `;
            } else {
                // Fallback if we can't extract the Python code and explanation
                return `<tr><td>1</td><td colspan="3" class="text-center">${formatPenjelasan(text)}</td></tr>`;
            }
        }
        
        // For beginner mode with detailed explanations (already in the expected format)
        try {
            // Use regex to find all items in the format: a. Java = ... Python = ... Penjelasan = ...
            const itemPattern = /([a-z])\.\s+Java\s*=\s*(.*?)(?=Python|$)\s*Python\s*=\s*(.*?)(?=Penjelasan|$)\s*Penjelasan\s*=\s*(.*?)(?=(?:[a-z]\.\s+Java)|$)/gs;
            
            let match;
            let rows = '';
            let rowIndex = 1;
            
            // Check if it matches the expected format
            if (text.includes("Java =") && text.includes("Python =") && text.includes("Penjelasan =")) {
                while ((match = itemPattern.exec(text)) !== null) {
                    const itemLabel = match[1]; // a, b, c, etc.
                    const javaCode = match[2].trim();
                    const pythonCode = match[3].trim();
                    const penjelasan = match[4].trim();
                    
                    rows += `
                        <tr>
                            <td>${itemLabel}</td>
                            <td><code class="code-block">${pythonCode.replace(/\n/g, '<br>')}</code></td>
                            <td><code class="code-block">${javaCode.replace(/\n/g, '<br>')}</code></td>
                            <td>${formatPenjelasan(penjelasan)}</td>
                        </tr>
                    `;
                }
                
                // If no matches found using regex, try a simpler approach
                if (!rows) {
                    // Split by lettered sections (a., b., etc.)
                    const sections = text.split(/\n[a-z]\.\s/).filter(Boolean);
                    
                    sections.forEach((section, index) => {
                        // Find Java, Python, and Penjelasan parts
                        const javaMatch = section.match(/Java\s*=\s*(.*?)(?=Python|Penjelasan|$)/s);
                        const pythonMatch = section.match(/Python\s*=\s*(.*?)(?=Java|Penjelasan|$)/s);
                        const penjelasanMatch = section.match(/Penjelasan\s*=\s*(.*?)(?=Java|Python|$)/s);
                        
                        if (javaMatch || pythonMatch || penjelasanMatch) {
                            const javaCode = javaMatch ? javaMatch[1].trim() : '';
                            const pythonCode = pythonMatch ? pythonMatch[1].trim() : '';
                            const penjelasan = penjelasanMatch ? penjelasanMatch[1].trim() : '';
                            
                            rows += `
                                <tr>
                                    <td>${String.fromCharCode(97 + index)}</td>
                                    <td><code class="code-block">${pythonCode.replace(/\n/g, '<br>')}</code></td>
                                    <td><code class="code-block">${javaCode.replace(/\n/g, '<br>')}</code></td>
                                    <td>${formatPenjelasan(penjelasan)}</td>
                                </tr>
                            `;
                        }
                    });
                }
                
                return rows || `<tr><td>1</td><td colspan="3">${formatPenjelasan(text)}</td></tr>`;
            } else {
                // If it doesn't match the expected format, just show as plain text
                return `<tr><td>1</td><td colspan="3">${formatPenjelasan(text)}</td></tr>`;
            }
        } catch (e) {
            console.error("Error parsing explanation:", e);
            return `<tr><td>1</td><td colspan="3">${text.replace(/\n/g, '<br>')}</td></tr>`;
        }
    }

    // Updated formatExplanationContent to handle different formats based on mode
    function formatExplanationContent(text) {
        if (!text || text.trim() === "") {
            return '<div class="text-center">Explanation not available.</div>';
        }
        
        // Check if the explanation contains HTML (like our guide link)
        if (text.includes('<a href')) {
            return `<div class="beginner-explanation">${text}</div>`;
        }
        
        // For expert mode - create simpler layout without table
        if (userLevel === 'expert') {
            // Try to extract Python code and explanation sections
            const pythonCodeMatch = text.match(/\d+\.\s+Python\s+Code\s*:\s*(```python[\s\S]*?```)/i);
            const explanationMatch = text.match(/\d+\.\s+Explanation\s*:\s*([\s\S]*?)(?=\d+\.|$)/i);
            
            if (pythonCodeMatch && explanationMatch) {
                const pythonCode = pythonCodeMatch[1].replace(/```python|```/g, '').trim();
                const explanation = explanationMatch[1].trim();
                
                return `
                    <div class="expert-explanation">
                        <h4>Python Code:</h4>
                        <pre class="code-block">${pythonCode.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</pre>
                        <h4>Explanation:</h4>
                        <p>${formatPenjelasan(explanation)}</p>
                    </div>
                `;
            } else {
                // If can't extract sections, display as is
                return `<div class="expert-explanation">${formatPenjelasan(text)}</div>`;
            }
        }
        
        // For beginner mode with detailed explanations - create a table
        if (text.includes("Java =") && text.includes("Python =") && text.includes("Penjelasan =")) {
            try {
                // Create table structure for beginner mode
                let tableHtml = `
                    <div class="table-responsive">
                        <table class="table table-bordered explanation-table">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">Item</th>
                                    <th width="30%">Python</th>
                                    <th width="30%">Java</th>
                                    <th width="35%">Penjelasan</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                
                // Use regex to find all items in the format
                const itemPattern = /([a-z])\.\s+Java\s*=\s*(.*?)(?=Python|$)\s*Python\s*=\s*(.*?)(?=Penjelasan|$)\s*Penjelasan\s*=\s*(.*?)(?=(?:[a-z]\.\s+Java)|$)/gs;
                
                let match;
                let hasRows = false;
                
                while ((match = itemPattern.exec(text)) !== null) {
                    hasRows = true;
                    const itemLabel = match[1]; // a, b, c, etc.
                    const javaCode = match[2].trim();
                    const pythonCode = match[3].trim();
                    const penjelasan = match[4].trim();
                    
                    tableHtml += `
                        <tr>
                            <td>${itemLabel}</td>
                            <td><code class="code-block">${pythonCode.replace(/\n/g, '<br>')}</code></td>
                            <td><code class="code-block">${javaCode.replace(/\n/g, '<br>')}</code></td>
                            <td>${formatPenjelasan(penjelasan)}</td>
                        </tr>
                    `;
                }
                
                tableHtml += `
                            </tbody>
                        </table>
                    </div>
                `;
                
                // If no matches found, return the original text
                if (!hasRows) {
                    return `<div class="beginner-explanation">${formatPenjelasan(text)}</div>`;
                }
                
                return tableHtml;
            } catch (e) {
                console.error("Error parsing explanation for table:", e);
                return `<div class="beginner-explanation">${formatPenjelasan(text)}</div>`;
            }
        } else {
            // If it doesn't match expected format, show as plain text
            return `<div class="beginner-explanation">${formatPenjelasan(text)}</div>`;
        }
    }

    // Helper function to get formatted Java code from editor
    function formatJavaCode() {
        const javaCode = javaEditor.getValue().trim();
        return javaCode ? javaCode.replace(/\n/g, '<br>') : 'No Java code available';
    }

    // Helper function to format explanation text with better styling
    function formatPenjelasan(text) {
        if (!text) return '';
        
        // Handle formatting
        let formattedText = text
            // Bold text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            // Italic text
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            // Code snippets
            .replace(/`(.*?)`/g, '<code class="code-block">$1</code>')
            // Line breaks
            .replace(/\n/g, '<br>');
        
        return formattedText;
    }

    // Update show explanation button to use the new formatting function
    showExplanationBtn.addEventListener("click", function() {
        // Get the explanation content container
        const modalExplanationContent = document.getElementById("modalExplanationContent");
        
        // Check if explanation is empty
        if (!explanation || explanation.trim() === "") {
            modalExplanationContent.innerHTML = '<div class="text-center">Explanation will appear after Java code is converted.</div>';
        } else {
            // Format and populate with explanation based on mode and format
            modalExplanationContent.innerHTML = formatExplanationContent(explanation);
            
            // Add the explanation to console for debugging purposes
            console.log("Explanation:", explanation);
        }
        
        // Position and size modal - restore original positioning
        const contentCol = document.querySelector('.col-md-9');
        const modalDialog = document.querySelector('#explanationModal .modal-dialog');
        
        if (contentCol && modalDialog && window.innerWidth > 850) {
            // Get the position of the content column
            const rect = contentCol.getBoundingClientRect();
            // Calculate position, keeping the left side aligned
            const leftPos = rect.left + (rect.width / 2) - 400; // Keep left position the same
            
            // Force apply explicit styling with scrollable content
            modalDialog.style.cssText = `
                position: fixed !important;
                top: 50px !important;
                left: ${Math.max(0, leftPos)}px !important;
                width: 800px !important;
                max-width: 800px !important;
                margin-left: 0 !important;
                transform: none !important;
            `;
            
            // Ensure modal body is scrollable
            const modalBody = document.querySelector('#explanationModal .modal-body');
            if (modalBody) {
                modalBody.style.maxHeight = '70vh';
                modalBody.style.overflowY = 'auto';
            }
        }
        
        // Show the modal
        $('#explanationModal').modal({
            backdrop: true,  // Allow clicking outside to close
            keyboard: true   // Allow ESC key to close
        });
    });

    // Configure CodeMirror for auto-formatting
    pythonEditor.setOption("extraKeys", {
        "Tab": function(cm) {
            if (cm.somethingSelected()) {
                cm.indentSelection("add");
            } else {
                cm.replaceSelection("    ", "end");
            }
        }
    });

    // Modified submitFeedback function to handle different surveys and CSV outputs
    function submitFeedback(responseValue) {
        const javaCode = javaEditor.getValue();
        const pythonCode = pythonEditor.getValue();
        const currentExplanation = explanation || "";
        const currentTips = tips || "";
        const feedbackComment = document.getElementById("feedbackCommentInput").value || "";

        // Create form data for feedback submission
        const formData = new FormData();
        formData.append('email', window.userEmail);
        formData.append('name', window.userName);
        formData.append('feedback', responseValue);
        formData.append('comment', feedbackComment);
        formData.append('level_cs', userLevel || 'beginner');
        
        // Only include these fields for beginner level
        if (userLevel === 'beginner') {
            formData.append('java_code', javaCode);
            formData.append('python_code', pythonCode);
            formData.append('explanation', currentExplanation);
            formData.append('tips', currentTips);
            formData.append('survey_type', 'feedback');
        } else {
            // For expert level, we only collect minimal data
            formData.append('survey_type', 'speed');
        }

        fetch(window.syntaxConverterFeedbackRoute, {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Replace feedback section with thank you message
            document.getElementById("feedbackSection").innerHTML = 
                "<p style='font-size: 16px; font-weight: bold;'>🙏 Terimakasih, saran anda berguna bagi kami.</p>";
        })
        .catch(error => {
            // Still show thank you message even if there's an error
            document.getElementById("feedbackSection").innerHTML = 
                "<p style='font-size: 16px; font-weight: bold;'>🙏 Terimakasih, saran anda berguna bagi kami.</p>";
            console.error("Feedback error:", error);
        });
    }

    // Modify the feedback submission process to handle the two-step approach
    function submitFeedback(responseValue, withComment = false) {
        // If it's the first step (for both beginner and expert modes now), show comment input
        if (!withComment) {
            // Display the comment input field
            const feedbackInputContainer = document.getElementById("feedbackInputContainer");
            feedbackInputContainer.style.display = "block";
            
            // Change button text
            const feedbackYesBtn = document.getElementById("feedbackYesBtn");
            const feedbackNoBtn = document.getElementById("feedbackNoBtn");
            feedbackYesBtn.textContent = "Send";
            feedbackNoBtn.style.display = "none"; // Hide the No button
            
            // Store the response value for later submission
            feedbackYesBtn.setAttribute('data-response', responseValue);
            
            // Change button functionality
            feedbackYesBtn.onclick = function() {
                const storedResponse = this.getAttribute('data-response');
                submitFeedback(storedResponse, true);
            };
            
            return; // Stop here, don't submit yet
        }
        
        // For second step of both modes, proceed with submission
        const javaCode = javaEditor.getValue();
        const pythonCode = pythonEditor.getValue();
        const currentExplanation = explanation || "";
        const currentTips = tips || "";
        const feedbackComment = document.getElementById("feedbackCommentInput").value || "";

        // Disable buttons to prevent multiple submissions
        const feedbackYesBtn = document.getElementById("feedbackYesBtn");
        const feedbackNoBtn = document.getElementById("feedbackNoBtn");
        if (feedbackYesBtn) feedbackYesBtn.disabled = true;
        if (feedbackNoBtn) feedbackNoBtn.disabled = true;

        // Create form data for feedback submission
        const formData = new FormData();
        formData.append('email', window.userEmail);
        formData.append('name', window.userName);
        formData.append('feedback', responseValue);
        formData.append('comment', feedbackComment);
        formData.append('level_cs', userLevel || 'beginner');
        formData.append('java_code', javaCode);
        formData.append('python_code', pythonCode);
        formData.append('explanation', currentExplanation);
        formData.append('tips', currentTips);
        
        // Include survey type based on user level
        if (userLevel === 'beginner') {
            formData.append('survey_type', 'feedback');
        } else {
            formData.append('survey_type', 'speed');
        }

        // Show loading state
        document.getElementById("feedbackSection").innerHTML = 
            "<p style='font-size: 16px; font-weight: bold;'><i class='fas fa-spinner fa-spin'></i> Sending your feedback...</p>";

        // Get the CSRF token directly from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(window.syntaxConverterFeedbackRoute, {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            // Check if response is ok before trying to parse JSON
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            // Try to parse as JSON, but handle non-JSON responses
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return response.json();
            } else {
                // If not JSON, return a simplified success object
                console.warn("Response was not JSON. Content type:", contentType);
                return { message: "Feedback received" };
            }
        })
        .then(data => {
            // Just show a thank you message
            document.getElementById("feedbackSection").innerHTML = 
                "<p style='font-size: 16px; font-weight: bold;'>🙏 Thank you, your feedback is valuable to us.</p>";
            
            // Hide the feedback section after a delay to make it less distracting for future conversions
            setTimeout(() => {
                document.getElementById("feedbackSection").style.display = "none";
            }, 3000);
        })
        .catch(error => {
            // Log the error but still show thank you message
            console.error("Feedback error:", error);
            document.getElementById("feedbackSection").innerHTML = 
                "<p style='font-size: 16px; font-weight: bold;'>🙏 Thank you, your feedback is valuable to us.</p>";
            
            // Hide the feedback section after delay
            setTimeout(() => {
                document.getElementById("feedbackSection").style.display = "none";
            }, 3000);
        });
    }

    // New function to reset the feedback section to its initial state
    function resetFeedbackSection() {
        // Get the feedback section
        const feedbackSection = document.getElementById("feedbackSection");
        
        // Check if the feedback section needs to be recreated (might have been replaced with thank you message)
        if (!document.getElementById("feedbackQuestion") || 
            !document.getElementById("feedbackInputContainer") || 
            !document.getElementById("feedbackButtonContainer")) {
            
            // Recreate the feedback section with its original structure
            feedbackSection.innerHTML = `
                <p class="feedback-question" style="font-size: 16px; font-weight: bold;" id="feedbackQuestion">
                    <!-- Question will be dynamically updated based on user level -->
                </p>
                <div class="form-group mb-3" id="feedbackInputContainer" style="display: none;">
                    <textarea id="feedbackCommentInput" class="form-control" placeholder="Enter your opinion (optional)" rows="2"></textarea>
                </div>
                <div id="feedbackButtonContainer">
                    <button id="feedbackYesBtn" class="btn btn-success mx-2">👍 Yes</button>
                    <button id="feedbackNoBtn" class="btn btn-danger mx-2">👎 No</button>
                </div>
            `;
        }
        
        // Reset feedback buttons to their original state
        const feedbackYesBtn = document.getElementById("feedbackYesBtn");
        const feedbackNoBtn = document.getElementById("feedbackNoBtn");
        
        if (feedbackYesBtn) {
            feedbackYesBtn.textContent = "👍 Yes";
            feedbackYesBtn.disabled = false;
            feedbackYesBtn.style.display = "inline-block";
            feedbackYesBtn.removeAttribute('data-response');
        }
        
        if (feedbackNoBtn) {
            feedbackNoBtn.textContent = "👎 No";
            feedbackNoBtn.disabled = false;
            feedbackNoBtn.style.display = "inline-block";
        }
        
        // Clear any existing comment
        const commentInput = document.getElementById("feedbackCommentInput");
        if (commentInput) {
            commentInput.value = "";
        }
    }

    // Helper function to attach event listeners to feedback buttons
    function attachFeedbackListeners() {
        let feedbackYesBtn = document.getElementById("feedbackYesBtn");
        let feedbackNoBtn = document.getElementById("feedbackNoBtn");
        
        // Clear any previous event listeners by cloning and replacing the elements
        if (feedbackYesBtn) {
            const newYesBtn = feedbackYesBtn.cloneNode(true);
            feedbackYesBtn.parentNode.replaceChild(newYesBtn, feedbackYesBtn);
            feedbackYesBtn = newYesBtn;
        }
        
        if (feedbackNoBtn) {
            const newNoBtn = feedbackNoBtn.cloneNode(true);
            feedbackNoBtn.parentNode.replaceChild(newNoBtn, feedbackNoBtn);
            feedbackNoBtn = newNoBtn;
        }
        
        // Add event listeners to the fresh buttons
        if (feedbackYesBtn) {
            feedbackYesBtn.addEventListener("click", function() {
                submitFeedback("ya", false);
            });
        }
        
        if (feedbackNoBtn) {
            feedbackNoBtn.addEventListener("click", function() {
                submitFeedback("tidak", false);
            });
        }
    }

    // Initial attachment of feedback listeners
    attachFeedbackListeners();

    // Add event listeners for load-conversion links
    document.querySelectorAll('.load-conversion').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const conversionId = this.getAttribute('data-id');
            if (conversionId) {
                loadConversion(conversionId);
                
                // Update URL with the conversion ID
                const url = new URL(window.location.href);
                url.searchParams.set('id', conversionId);
                window.history.pushState({}, '', url);
            }
        });
    });
    
    // Simplified toast function to prevent duplicates
    function showSimpleToast(message, type = 'success') {
        const toast = document.getElementById('saveToast');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastTime = document.getElementById('toastTime');
        
        // Clear any existing timers
        if (toast.hideTimer) {
            clearTimeout(toast.hideTimer);
        }
        
        // Update toast content
        toastMessage.textContent = message;
        toastTime.textContent = 'Baru saja';
        
        // Update icon and title based on type
        toastIcon.className = 'fas mr-2';
        
        switch(type) {
            case 'success':
                toastIcon.classList.add('fa-check-circle', 'success');
                toastTitle.textContent = 'Success';
                break;
            case 'danger':
                toastIcon.classList.add('fa-exclamation-circle', 'danger');
                toastTitle.textContent = 'Error';
                break;
            case 'warning':
                toastIcon.classList.add('fa-exclamation-triangle', 'warning');
                toastTitle.textContent = 'Warning';
                break;
            case 'info':
                toastIcon.classList.add('fa-info-circle', 'info');
                toastTitle.textContent = 'Information';
                break;
            default:
                toastIcon.classList.add('fa-bell', 'info');
                toastTitle.textContent = 'Notification';
        }
        
        // Hide any currently showing toast
        toast.classList.remove('show');
        
        // Show the toast after a brief delay (to ensure animation works)
        setTimeout(() => {
            toast.classList.add('show');
            
            // Hide toast after 3 seconds
            toast.hideTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }, 10);
        
        // Add click handler for close button
        const closeBtn = toast.querySelector('.close');
        if (closeBtn) {
            closeBtn.onclick = function() {
                toast.classList.remove('show');
                if (toast.hideTimer) {
                    clearTimeout(toast.hideTimer);
                }
            };
        }
    }
    
    // Enhanced toast function with animations and better styling
    function showEnhancedToast(message, type = 'success', autoHide = true) {
        const toast = document.getElementById('saveToast');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastTime = document.getElementById('toastTime');
        
        // Clear any existing timers
        if (toast.hideTimer) {
            clearTimeout(toast.hideTimer);
        }
        
        // Hide the time element
        if (toastTime) {
            toastTime.style.display = 'none';
        }
        
        // Update toast content
        toastMessage.textContent = message;
        
        // Update icon, title, and color based on type
        toastIcon.className = 'fas mr-2';
        toast.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-info');
        
        switch(type) {
            case 'success':
                toastIcon.classList.add('fa-check-circle', 'success');
                toastTitle.textContent = 'Success';
                toast.style.borderLeft = '4px solid #28a745';
                break;
            case 'danger':
                toastIcon.classList.add('fa-exclamation-circle', 'danger');
                toastTitle.textContent = 'Error';
                toast.style.borderLeft = '4px solid #dc3545';
                break;
            case 'warning':
                toastIcon.classList.add('fa-exclamation-triangle', 'warning');
                toastTitle.textContent = 'Warning';
                toast.style.borderLeft = '4px solid #ffc107';
                break;
            case 'info':
                toastIcon.classList.add('fa-info-circle', 'info');
                toastTitle.textContent = 'Information';
                toast.style.borderLeft = '4px solid #17a2b8';
                break;
            default:
                toastIcon.classList.add('fa-bell', 'info');
                toastTitle.textContent = 'Notification';
                toast.style.borderLeft = '4px solid #17a2b8';
        }
        
        // Hide the close button
        const closeBtn = toast.querySelector('.close');
        if (closeBtn) {
            closeBtn.style.display = 'none';
        }
        
        // Hide any currently showing toast
        toast.classList.remove('show');
        setTimeout(() => {
            toast.classList.add('show');
            toast.style.transform = 'translateX(0)';
            toast.style.opacity = '1';
            
            // Hide toast after delay if autoHide is true
            if (autoHide) {
                toast.hideTimer = setTimeout(() => {
                    toast.style.transform = 'translateX(400px)';
                    toast.style.opacity = '0';
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 300);
                }, 3000);
            }
        }, 10);
    }
    
    // Function to highlight an item in the history list
    function highlightHistoryItem(id) {
        if (!id) return;
        
        fetch(window.location.pathname)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                // Preserve the first li (the "Konversi Baru" button)
                const preservedItem = document.querySelector('.card-body .list-group li:first-child').outerHTML;
                // Get updated conversion items (all except first li)
                const newItems = doc.querySelectorAll('.card-body .list-group li:not(:first-child)');
                let newItemsHTML = '';
                newItems.forEach(item => {
                    newItemsHTML += item.outerHTML;
                });
                const currentHistoryList = document.querySelector('.card-body .list-group');
                currentHistoryList.innerHTML = preservedItem + newItemsHTML;
                
                // Reattach load-conversion event listeners for conversion items
                document.querySelectorAll('.load-conversion').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const conversionId = this.getAttribute('data-id');
                        if (conversionId) {
                            loadConversion(conversionId);
                            const url = new URL(window.location.href);
                            url.searchParams.set('id', conversionId);
                            window.history.pushState({}, '', url);
                        }
                    });
                });
                
                // Reattach the "Konversi Baru" button event listener with COMPLETE reset functionality
                document.getElementById("newConversionBtn").addEventListener("click", function() {
                    // Reset all variables completely
                    pythonEditor.setValue("");
                    pythonEditor.setOption("readOnly", false);
                    pythonOutput.textContent = "Output will be displayed here after running Python code.";
                    conversionTitle.value = "";
                    javaEditor.setValue("");
                    pythonCode = "";
                    explanation = "";
                    tips = "";
                    currentConversionId = null;
                    
                    // IMPORTANT: Always reset execution time display
                    const executionTimeDisplay = document.getElementById("executionTimeDisplay");
                    if (executionTimeDisplay) {
                        executionTimeDisplay.textContent = "";
                    }
                    
                    // Hide tips section
                    document.getElementById("tipSection").style.display = "none";
                    
                    // Remove id from URL if present
                    const url = new URL(window.location.href);
                    url.searchParams.delete('id');
                    window.history.pushState({}, '', url);
                });
                
                // Highlight the newly saved item
                const selectedItem = document.querySelector(`.load-conversion[data-id="${id}"]`);
                if (selectedItem) {
                    const parent = selectedItem.closest('li');
                    if (parent) {
                        parent.style.backgroundColor = 'rgba(40,167,69,0.1)';
                        parent.style.transition = 'background-color 1s ease';
                        setTimeout(() => {
                            parent.style.backgroundColor = '';
                        }, 2000);
                    }
                }
            })
            .catch(error => {
                console.error('Error refreshing history list:', error);
            });
    }
});
