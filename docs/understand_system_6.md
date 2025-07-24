
# Chapter 3: Research Methodology

## 3.1 Introduction

This chapter outlines the methodological approach for the National Centralised Patient Portal project, encompassing both research and development aspects. The methodology has been designed to address the complex, multifaceted nature of the project, which requires understanding user needs across diverse stakeholder groups, analyzing technical integration requirements across heterogeneous healthcare systems, and developing an effective software solution that meets stakeholder needs and regulatory compliance standards while delivering a robust, secure unified platform with positive user experience.

## 3.2 Data Collection Methods

A mixed-methods approach will be employed to gather comprehensive data regarding user requirements, system constraints, and contextual factors. This approach combines quantitative methods providing statistical insights with qualitative methods offering depth of understanding, creating a robust foundation for evidence-based decision-making throughout the project lifecycle.

### 3.2.1 Quantitative Data Collection

Quantitative methods will be employed to gather measurable data regarding user preferences, current challenges, and priority features:

**1\. National Healthcare Survey**

A structured survey will be developed and distributed to a representative sample of the national population, stratified by age, gender, geographic location, and healthcare utilization patterns. The survey will collect data on:

- Current methods of accessing healthcare information
- Frequency of interaction with healthcare providers
- Digital literacy and technology adoption patterns
- Preferences for portal features and functionality
- Concerns regarding digital health information
- Access to digital devices and internet connectivity

The survey will employ validated instruments where available, including the System Usability Scale (SUS) and the eHealth Literacy Scale (eHEALS), to ensure reliability and comparability with existing research.

**2\. Healthcare Provider Capability Assessment**

A structured questionnaire will be administered to IT leaders and clinical administrators across selected public and private healthcare providers to assess:

- Current digital health infrastructure
- Electronic health record system capabilities
- Interoperability readiness
- Data standardization practices
- Technical resource availability
- Current patient engagement technologies

This assessment will provide critical information regarding integration requirements and potential technical constraints for the centralized portal.

**3\. Portal Usage Analytics**

For existing digital health services within the country, usage analytics will be collected (with appropriate permissions) to understand:

- User engagement patterns
- Feature utilization rates
- Device and browser preferences
- Common navigation paths
- Error frequency and abandonment points

These analytics will inform interface design decisions and help prioritize features based on demonstrated user behavior rather than solely on stated preferences.

**4\. Performance Benchmarking**

Performance metrics from similar implementations in comparable healthcare systems will be collected through literature review and direct outreach to benchmark:

- Adoption rates by demographic segment
- Time-to-integration for various provider types
- Security incident frequencies
- System reliability metrics
- Cost parameters for implementation and maintenance

These benchmarks will establish realistic targets for the project and inform risk assessment and mitigation strategies.

### 3.2.2 Qualitative Data Collection

Qualitative methods will provide deeper insights into user needs, concerns, and contextual factors that may impact portal design and implementation:

**1\. Focus Groups**

A series of focus groups will be conducted with diverse participant groups including:

- Patients with chronic conditions requiring regular healthcare interaction
- Elderly patients with varying levels of digital literacy
- Caregivers who manage healthcare for dependents
- Young adults with high digital literacy
- Representatives from rural and underserved communities
- Individuals with disabilities who may have specific accessibility requirements

Each focus group (8-12 participants) will explore attitudes toward digital health tools, perceived barriers to adoption, feature priorities, and concerns regarding information sharing.

**2\. Semi-Structured Interviews**

In-depth interviews will be conducted with key stakeholders including:

- Healthcare administrators from major providers
- Clinical leaders representing various specialties
- Health information technology professionals
- Patient advocacy representatives
- Privacy and security specialists
- MOH officials responsible for healthcare coordination

Interviews will explore organizational perspectives, integration challenges, workflow implications, and strategic alignment of the portal with broader healthcare initiatives.

**3\. Contextual Inquiry and Observation**

Observational research will be conducted at selected public and private healthcare facilities to understand:

- Current information management workflows
- Patient-provider interactions around information exchange
- Physical and technical constraints in clinical environments
- Workarounds employed for current system limitations

This direct observation will reveal practical challenges and opportunities that might not emerge through other data collection methods.

**4\. Usability Testing**

Throughout the design and development process, qualitative usability testing will be conducted with representative users to evaluate:

- Navigation intuitiveness
- Information findability
- Task completion success
- Error recovery
- Subjective satisfaction
- Accessibility compliance

Testing will employ think-aloud protocols, task-based assessments, and post-test interviews to gather rich qualitative data regarding the user experience.

## 3.3 Data Analysis Methods

### 3.3.1 Sampling Techniques

Robust sampling strategies will be employed to ensure that data collection efforts capture the diversity of the target population and stakeholder groups:

**1\. Representative Population Sampling**

For the national survey, stratified random sampling will be used to ensure representation across:

- Age groups (18-30, 31-50, 51-65, 66+)
- Gender demographics
- Geographic regions (urban, suburban, rural)
- Socioeconomic segments (using education and income as proxies)
- Healthcare utilization levels (frequent, occasional, rare users)

The sampling frame will be developed using national census data supplemented by healthcare utilization statistics from the MOH.

**2\. Purposive Sampling for Qualitative Research**

For qualitative research components, purposive sampling will be employed to ensure inclusion of:

- Individuals with varying technology adoption patterns (early adopters, mainstream users, late adopters)
- Representatives of potentially vulnerable populations (elderly, disabled, linguistically diverse)
- Healthcare professionals across specialties and practice settings
- Technical specialists with relevant expertise in health informatics and cybersecurity

This approach will ensure that diverse perspectives inform the design and implementation strategy.

**3\. Provider Sampling Strategy**

For healthcare provider assessment, stratified sampling will be used to include:

- Major public hospitals and health centers
- Specialized treatment facilities
- Private hospitals of varying sizes
- Individual and group practices
- Rural health centers
- Providers serving specialized populations

This diversity will ensure that integration requirements account for the full spectrum of healthcare delivery models within the national system.

**4\. Theoretical Sampling for Emerging Issues**

As data analysis progresses, theoretical sampling will be employed to follow up on emerging themes or issues, ensuring that important areas identified during initial analysis receive adequate exploration through additional targeted data collection.

### 3.3.2 Data Analysis

A comprehensive data analysis approach will be employed to derive actionable insights from collected data:

**1\. Quantitative Analysis**

Statistical analysis of survey data and usage analytics will include:

- Descriptive statistics to characterize respondent demographics and baseline measures
- Inferential statistics to identify significant relationships between variables
- Factor analysis to identify underlying dimensions in user preferences
- Cluster analysis to identify distinct user segments with similar needs or behaviors
- Regression modeling to understand predictors of adoption intent

Statistical analysis will be conducted using R and SPSS software, with a significance level of p<0.05 established for hypothesis testing.

**2\. Qualitative Analysis**

Qualitative data from interviews, focus groups, and observations will be analyzed using thematic analysis:

- Transcription and familiarization with data
- Initial coding using both inductive and deductive approaches
- Theme development and refinement
- Thematic mapping to identify relationships between themes
- Integration of themes into a coherent analytic narrative

**3\. Requirements Analysis**

Data from both quantitative and qualitative sources will be synthesized into a comprehensive requirements document using:

- User story development based on identified needs
- Prioritization matrices incorporating frequency of mention and impact assessment
- Affinity diagramming to group related requirements
- Traceability matrices to link requirements to data sources

Requirements will be categorized as essential (must-have), important (should-have), or desirable (could-have) to inform prioritization during implementation planning.

**4\. Usability Evaluation Analysis**

Usability testing data will be analyzed using:

- Task success rates and time-on-task metrics
- Error frequency and severity classification
- Standardized usability questionnaires (SUS, PSSUQ)
- Qualitative coding of think-aloud protocols
- Heat map analysis of interaction patterns

These analyses will produce actionable design recommendations throughout the iterative development process.

**5\. Triangulation and Integration**

Findings from different data sources will be triangulated to identify convergence, complementarity, or divergence, strengthening the validity of conclusions and highlighting areas requiring further investigation. Integration of quantitative and qualitative findings will be facilitated through joint displays, narrative weaving, and theme quantification where appropriate.